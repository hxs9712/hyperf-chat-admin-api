<?php

namespace App\Controller;

use App\Common\Lang\LangType;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;

class LangController extends AbstractController
{

    public function getlang(RequestInterface $request, ResponseInterface $response)
    {
        $lang_type = $request->input('lang_type', 1);
        $langType = LangType::$lang_type[$lang_type];

        $lang = (new $langType())->getlang();

        return $this->result(200, '操作成功', $lang);
    }
}