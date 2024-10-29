<?php

class SamlResponse
{
    protected $Config;
    public $Document;

    public function __construct($config, $assertion)
    {
        $this->Config = $config;

        $this->Document = new DOMDocument();
        $this->Document->loadXML(base64_decode($assertion));
    }

    public function IsTokenValid()
    {
        $xmlSec = new TokenValidator($this->Config, $this);
        return $xmlSec->IsTokenValid();
    }

    public function NameId()
    {
        $entries = $this->Navigate('/saml:Subject/saml:NameID');
        return $entries->item(0)->nodeValue;
    }

    public function GetAttributes()
    {
        $entries = $this->Navigate('/saml:AttributeStatement/saml:Attribute');
        $attributes = array();
        
        foreach ($entries as $entry) 
        {
            $attributeName = $entry->attributes->getNamedItem('Name')->nodeValue;
            $attributeValues = array();

            foreach ($entry->childNodes as $childNode) 
            {
                if ($childNode->tagName === 'saml:AttributeValue')
                {
                    $attributeValues[] = $childNode->nodeValue;
                }
            }

            $attributes[$attributeName] = $attributeValues;
        }

        return $attributes;
    }

    protected function Navigate($path)
    {
        $xpath = new DOMXPath($this->Document);
        $xpath->registerNamespace('samlp', 'urn:oasis:names:tc:SAML:2.0:protocol');
        $xpath->registerNamespace('saml', 'urn:oasis:names:tc:SAML:2.0:assertion');
        $xpath->registerNamespace('ds', 'http://www.w3.org/2000/09/xmldsig#');

        $signatureQuery = '/samlp:Response/saml:Assertion/ds:Signature/ds:SignedInfo/ds:Reference';

        $assertionReferenceNode = $xpath->query($signatureQuery)->item(0);

        if (!$assertionReferenceNode) 
        {
			// checking response is signed instead of assertion
			$signatureQuery = '/samlp:Response/ds:Signature/ds:SignedInfo/ds:Reference';
			$assertionReferenceNode = $xpath->query($signatureQuery)->item(0);
		
			if (!$assertionReferenceNode) 
			{
				throw new Exception('Signature reference missing');
			}
        }
        
        $id = substr($assertionReferenceNode->attributes->getNamedItem('URI')->nodeValue, 1);
        $nameQuery = "/samlp:Response/saml:Assertion" . $path;
        
        return $xpath->query($nameQuery);
    }
}

?>