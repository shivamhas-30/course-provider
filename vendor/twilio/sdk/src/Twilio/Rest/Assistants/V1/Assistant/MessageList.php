<?php

/**
 * This code was generated by
 * ___ _ _ _ _ _    _ ____    ____ ____ _    ____ ____ _  _ ____ ____ ____ ___ __   __
 *  |  | | | | |    | |  | __ |  | |__| | __ | __ |___ |\ | |___ |__/ |__|  | |  | |__/
 *  |  |_|_| | |___ | |__|    |__| |  | |    |__] |___ | \| |___ |  \ |  |  | |__| |  \
 *
 * Twilio - Assistants
 * This is the public Twilio REST API.
 *
 * NOTE: This class is auto generated by OpenAPI Generator.
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace Twilio\Rest\Assistants\V1\Assistant;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Values;
use Twilio\Version;


class MessageList extends ListResource
    {
    /**
     * Construct the MessageList
     *
     * @param Version $version Version that contains the resource
     * @param string $id the Assistant ID.
     */
    public function __construct(
        Version $version,
        string $id
    ) {
        parent::__construct($version);

        // Path Solution
        $this->solution = [
        'id' =>
            $id,
        
        ];

        $this->uri = '/Assistants/' . \rawurlencode($id)
        .'/Messages';
    }

    /**
     * Create the MessageInstance
     *
     * @param AssistantsV1ServiceAssistantSendMessageRequest $assistantsV1ServiceAssistantSendMessageRequest
     * @return MessageInstance Created MessageInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function create(AssistantsV1ServiceAssistantSendMessageRequest $assistantsV1ServiceAssistantSendMessageRequest): MessageInstance
    {

        $headers = Values::of(['Content-Type' => 'application/x-www-form-urlencoded' ]);
        $data = $assistantsV1ServiceAssistantSendMessageRequest->toArray();
        $headers['Content-Type'] = 'application/json';
        $payload = $this->version->create('POST', $this->uri, [], $data, $headers);

        return new MessageInstance(
            $this->version,
            $payload,
            $this->solution['id']
        );
    }


    /**
     * Provide a friendly representation
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string
    {
        return '[Twilio.Assistants.V1.MessageList]';
    }
}
