<?php

class FederationConfig
{
    const NameId = 'urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress';
    
    public $IdPSignOutUrl = '';
    public $IdpSingleSignOnUrl = '';
    public $IdPSigningKey= '';
    public $ReplyToUrl = '';
    public $ServiceProviderIssuer = 'urn:my:service:provider';
    public $NameIdFormat = self::NameId;
}
?>