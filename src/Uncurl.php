<?php

namespace Exfriend\Uncurl;

/**
 * Class Uncurl
 * @package Exfriend\Uncurl
 */
class Uncurl
{
    /**
     * The URL to unfurl.
     * @var string
     */
    protected $url;
    /**
     * cURL timeout
     * @var int
     */
    protected $timeout = 4;
    /**
     * Array of all locations found in the redirect chain
     * @var array
     */
    protected $locations = [];
    /**
     * Flag to remember if we already checked the URL
     * @var bool
     */
    protected $checked = false;

    /**
     * Uncurl constructor.
     * @param $url
     */
    public function __construct( $url )
    {
        $this->url = $url;
    }

    /**
     * Get all locations in the redirect chain
     * @return array
     */
    public function all()
    {
        if ( !$this->checked )
        {
            $this->load();
        }

        return $this->locations;
    }


    /**
     * Get the first location in the redirect chain
     * @return mixed
     */
    public function first()
    {
        $l = $this->all();
        return array_shift( $l );
    }

    /**
     * Get the final destination
     * @return string
     */
    public function last()
    {
        $l = $this->all();
        return array_pop( $l );
    }

    /**
     * Load the URL and remember all "Location" headers.
     */
    protected function load()
    {
        $ch = curl_init( $this->url );
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_HEADER, true );
        curl_setopt( $ch, CURLOPT_NOBODY, true );
        curl_setopt( $ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36' );

        curl_setopt( $ch, CURLOPT_TIMEOUT, $this->timeout );
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $this->timeout );

        curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );

        $resp = curl_exec( $ch );
        curl_close( $ch );

        if ( preg_match_all( '~Location: (.*?)\s~is', $resp, $o ) )
        {
            $this->locations = $o[ 1 ];
        }

        $this->checked = true;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->last();
    }
}
