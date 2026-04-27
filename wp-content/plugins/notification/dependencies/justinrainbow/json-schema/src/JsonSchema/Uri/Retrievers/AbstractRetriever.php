<?php
/**
 * JsonSchema
 *
 * @filesource
 *
 * @license MIT
 * Modified by bracketspace on 05-September-2025 using {@see https://github.com/BrianHenryIE/strauss}.
 */

namespace BracketSpace\Notification\Dependencies\JsonSchema\Uri\Retrievers;

/**
 * AbstractRetriever implements the default shared behavior
 * that all descendant Retrievers should inherit
 *
 * @author Steven Garcia <webwhammy@gmail.com>
 */
abstract class AbstractRetriever implements UriRetrieverInterface
{
    /**
     * Media content type
     *
     * @var string
     */
    protected $contentType;

    /**
     * {@inheritdoc}
     *
     * @see \BracketSpace\Notification\Dependencies\JsonSchema\Uri\Retrievers\UriRetrieverInterface::getContentType()
     */
    public function getContentType()
    {
        return $this->contentType;
    }
}
