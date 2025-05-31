<?php

require_once 'BaseDto.php';

class ProviderListItemDto extends BaseDto {
    public $id;
    public $name;
    public $logo_url;
    public $website_url;
    public $status;
}