<?php
namespace App\Service;

class XMLReaderService
{
    private $_name = null;
    private $_url = null;
    private $_cacheService = null;
    private $_xml = null;
    private $_ttl = null;
    
    const DEFAULT_TTL = 1800;

    public function __construct($name, $url, $cacheService, $ttl = self::DEFAULT_TTL)
    {
        $this->_name = $name;
        $this->_url = $url;
        $this->_cacheService = $cacheService;
        $this->_ttl = $ttl;
    }
    
    public function getContent()
    {
        return $this->_xml();
    }
    
    private function _xml()
    {
        if (!$this->_xml) {
            $this->_xml = $this->_getXml();
        }
        return $this->_xml;
    }
    
    private function _getXml()
    {
        $xml = $this->_getCachedXml();
        if (!$xml) {
            $xml = $this->_refreshXml();
        }
        return $xml;
    }
    
    private function _getCachedXml()
    {
        $xml = $this->_cacheService->get($this->_name);
        if ($xml) {
            $xml = $this->_unserializeXML($xml);
        }
        return $xml;
    }
    
    private function _refreshXml()
    {
        $xml = $this->_loadXml();
        if ($xml) {
            $this->_cacheXml($xml);
        }
        return $xml;
    }
    
    private function _cacheXml($xml)
    {
        $this->_cacheService->set($this->_name, $this->_serializeXML($xml));
        $this->_cacheService->expire($this->_name, $this->_ttl);
    }
    
    private function _loadXml()
    {
        return simplexml_load_file($this->_url);
    }
    
    private function _serializeXML($xml)
    {
        return json_encode($xml);
    }
    
    private function _unserializeXML($serializedXML)
    {
        return json_decode($serializedXML);
    }
    
    public function getAtributes()
    {
        return $this->_getXml()->attributes();
    }
}
