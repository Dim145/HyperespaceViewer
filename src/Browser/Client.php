<?php


namespace App\Browser;


use Symfony\Component\BrowserKit\AbstractBrowser;
use Symfony\Component\BrowserKit\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Client extends AbstractBrowser
{
    private HttpClientInterface $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        parent::__construct();
        $this->httpClient = $httpClient;
    }

    protected function doRequest($request)
    {
        $resp = $this->httpClient->request($request->getMethod(), $request->getUri(), $request->getParameters());

        return new Response($resp->getContent(),$resp->getStatusCode(), $resp->getHeaders());
    }
}
