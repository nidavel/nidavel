<?php

namespace Nidavel\Feed\Classes;

class SimpleXMLExtended extends \SimpleXMLElement {
    // Create CDATA section custom function.
    public function addCData($cdata_text) {
        $node              = dom_import_simplexml($this); 
        $ownerDocumentNode = $node->ownerDocument;
        
        $node->appendChild($ownerDocumentNode->createCDATASection($cdata_text));
    }
}
