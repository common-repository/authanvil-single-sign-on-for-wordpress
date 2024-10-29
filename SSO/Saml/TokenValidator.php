<?php

class TokenValidator
{
    protected $Config;
    protected $Document;

    public function __construct($config, $response)
    {
        $this->Config = $config;
        $this->Document = clone $response->Document;
    }

    public function ValidateTimestamp()
    {
        $rootNode = $this->Document;

        $timestampNodes = $rootNode->getElementsByTagName('Conditions');
        
        for ($i = 0; $i < $timestampNodes->length; $i++) 
        {
            $nbAttribute = $timestampNodes->item($i)->attributes->getNamedItem("NotBefore");
            $naAttribute = $timestampNodes->item($i)->attributes->getNamedItem("NotOnOrAfter");
        
            if ($nbAttribute && strtotime($nbAttribute->textContent) > time()) 
            {
                return false;
            }
            
            if ($naAttribute && strtotime($naAttribute->textContent) <= time()) 
            {
                return false;
            }
        }

        return true;
    }
    
    public function IsTokenValid()
    {
        $objXMLSecDSig = new XMLSecurityDSig();

        $objDSig = $objXMLSecDSig->locateSignature($this->Document);

        if (!$objDSig) 
        {
            throw new Exception('Missing signature');
        }

        $objXMLSecDSig->canonicalizeSignedInfo();
        $objXMLSecDSig->idKeys = array('ID');

        $retVal = $objXMLSecDSig->validateReference();
        
        if (!$retVal) 
        {
            throw new Exception('Reference Validation Failed');
        }

        $validTimestamps = $this->ValidateTimestamp();
        
        if (!$validTimestamps) 
        {
            throw new Exception('Timestamp is invalid. Check clock skew.');
        }

        $objKey = $objXMLSecDSig->locateKey();

        if (!$objKey) 
        {
            throw new Exception('Cannot find key');
        }

        XMLSecEnc::staticLocateKeyInfo($objKey, $objDSig);

        $objKey->loadKey($this->Config->IdPSigningKey, FALSE, TRUE);

        return ($objXMLSecDSig->verify($objKey) === 1);
    }
}
?>