<?php
/**
 * File: ReactPHPRequestAdapter.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\Otomoto\Middleware\Webpage\Adapter\ReactPHP;

use MSlwk\Otomoto\Middleware\Webpage\Adapter\ReactPHP\Handler\ErrorHandler;
use MSlwk\Otomoto\Middleware\Webpage\Adapter\ReactPHP\Handler\ResponseHandler;
use MSlwk\Otomoto\Middleware\Webpage\Data\UrlDTOArray;
use MSlwk\Otomoto\Middleware\Webpage\Data\WebpageDTO;
use MSlwk\Otomoto\Middleware\Webpage\Data\WebpageDTOArray;
use MSlwk\Otomoto\Middleware\Webpage\Exception\GETHandlerException;
use React\EventLoop\LoopInterface;
use React\HttpClient\Client;
use React\HttpClient\Response;
use MSlwk\Otomoto\Middleware\Webpage\Adapter\GETHandlerInterface;

/**
 * Class ReactPHPRequestAdapter
 * @package MSlwk\Otomoto\Middleware\Webpage\Adapter\ReactPH
 */
class ReactPHPRequestAdapter implements GETHandlerInterface
{
    /**
     * @var LoopInterface
     */
    private $loop;

    /**
     * @var ClientFactory
     */
    private $clientFactory;

    /**
     * ReactPHPRequestAdapter constructor.
     * @param LoopInterface $loop
     * @param ClientFactory $clientFactory
     */
    public function __construct(
        LoopInterface $loop,
        ClientFactory $clientFactory
    ) {
        $this->loop = $loop;
        $this->clientFactory = $clientFactory;
    }

    /**
     * @param UrlDTOArray $urlDTOArray
     * @return WebpageDTOArray
     */
    public function getWebpages(UrlDTOArray $urlDTOArray): WebpageDTOArray
    {
        $webpageDTOArray = new WebpageDTOArray();
        foreach ($urlDTOArray as $urlDTO) {
            $client = $this->clientFactory->create($this->loop);
            $request = $client->request('GET', $urlDTO->getUrl());
            $request->on('response', function (Response $response) use (&$webpageDTOArray) {
                $data = '';
                $response->on(
                    'data',
                    function ($chunk) use (&$webpageDTOArray, &$data) {
                        $data .= $chunk;
                    }
                )->on(
                    'end',
                    function () use (&$webpageDTOArray, &$data) {
                        $webpageDTOArray->add(new WebpageDTO($data));
                    }
                );
            });
            $request->end();
        }
        $this->loop->run();
        $this->validateWebpages($webpageDTOArray);
        return $webpageDTOArray;
    }

    /**
     * @param WebpageDTOArray $webpageDTOArray
     * @throws GETHandlerException
     */
    private function validateWebpages(WebpageDTOArray $webpageDTOArray)
    {
        if (!$webpageDTOArray->count()) {
            throw new GETHandlerException('An error occurred, no result found');
        }
    }
}
