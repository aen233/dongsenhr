<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;

class After
{
    /**
     * 处理成功返回自定义格式
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if (is_array($response)) {
            return $response;
        }

        if (401 == $response->getStatusCode()) {
            $err = json_decode($response->getContent(), true) ?? [];

            switch ($err['error']) {
                case 'invalid_credentials':
                    return  [
                        'code'    => 402,
                        'message' => '密码错误',
                    ];
                    break;
                case 'invalid_client':
                    return  [
                        'code'    => 403,
                        'message' => '客户端校验失败',
                    ];
                    break;
                default:
                    return  [
                        'code'    => 401,
                        'message' => 'Unauthorized',
                        'data'    => $err
                    ];
            }
        }

        // 如果是导出Excel类型直接返回
        if ($response instanceof BinaryFileResponse) {
            return $response;
        }

        if ($response instanceof RedirectResponse) {
            return $response;
        }

        // 执行动作
        $oriData = method_exists($response, 'getOriginalContent')
            ? $response->getOriginalContent()
            : $response->getContent();

        $content = json_decode($response->getContent(), true) ?? $oriData;
        $content = is_array($oriData) ? $oriData : $content;

        if ($content['code'] ?? 0) {
            return $response;
        }

        $data['data'] = isset($content['data']) ? $content['data'] : $content;

        if ($content['meta'] ?? []) {
            $data['meta'] = [
                'total' => $content['meta']['total'],
                'page'  => $content['meta']['page'] ?? $content['meta']['current_page'] ?? 0,
                'size'  => $content['meta']['size'] ?? $content['meta']['per_page'] ?? 0,
            ];
        }

        if ($oriData instanceof LengthAwarePaginator) {
            $data['meta'] = [
                'total' => $content['total'],
                'page'  => $content['current_page'],
                'size'  => (int)$content['per_page'],
            ];
        }

        if ($data['data']['data'] ?? []) {
            $data['data'] = $data['data']['data'];
        }

        $sqlFilename = storage_path('/logs/sql.log');
        if (request('dumpSql', 0) && file_exists($sqlFilename)) {
            $data['sql'] = $this->readFileByLine($sqlFilename);
        }

        $message = ['code' => 0, 'message' => 'success', 'data' => []];
        $temp    = ($content) ? array_merge($message, $data) : $message;

        if ($response instanceof Response && is_array($temp)) {
            return $temp;
        }

        $response = $response instanceof JsonResponse ? $response->setData($temp) : $response->setContent($temp);

        return $response;
    }

    protected function readFileByLine($filename)
    {
        $fh = fopen($filename, 'r');

        $sql = [];
        while (!feof($fh)) {
            $sql[] = json_decode(fgets($fh), true);
        }

        fclose($fh);

        if (is_null(end($sql))) {
            array_pop($sql);
        }

        return $sql;
    }
}
