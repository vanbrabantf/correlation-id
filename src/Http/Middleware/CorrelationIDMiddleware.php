<?php

/**
 * Copyright (c) Florian Krämer (https://florian-kraemer.net)
 * Licensed under The GPL3 License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Florian Krämer (https://florian-kraemer.net)
 * @author    Florian Krämer
 * @link      https://github.com/Phauthentic
 * @license   https://opensource.org/licenses/MIT MIT License
 */

declare(strict_types=1);

namespace Phauthentic\Infrastructure\Http\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Correlation Id Middleware
 */
class CorrelationIDMiddleware implements MiddlewareInterface
{

    /**
     * @var string
     */
    protected $correlationId;

    /**
     * @var string
     */
    protected $attributeName = 'CorrelationID';

    /**
     * @var string
     */
    protected $headerName = 'CorrelationID';

    /**
     * Constructor
     *
     * @param string $correlationId Correlation Id
     * @param string $attributeName Attribute Name
     * @param string $headerName Header Name
     */
    public function __construct(
        string $correlationId,
        string $attributeName = 'CorrelationID',
        string $headerName = 'CorrelationID'
    ) {
        $this->correlationId = $correlationId;
        $this->attributeName = $attributeName;
        $this->headerName = $headerName;
    }

    /**
     * Process an incoming server request.
     * Processes an incoming server request in order to produce a response.
     * If unable to produce the response itself, it may delegate to the provided
     * request handler to do so.
     */
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        $request = $request->withAttribute(
            $this->attributeName,
            $this->correlationId
        );

        $request = $request->withHeader(
            $this->headerName,
            $this->correlationId
        );

        return $handler->handle($request);
    }
}
