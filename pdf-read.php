<?php
require 'vendor/autoload.php';

use Smalot\PdfParser\Parser;

function extractAndProcessCode($pdfFilePath) {
    // Initialize the parser
    $parser = new Parser();
    // Parse the PDF file
    $pdf = $parser->parseFile($pdfFilePath);
    
    // Extract text from the PDF
    $text = $pdf->getText();
    
    // Define the pattern to find "CODE: ..."
    $pattern = '/(CODE:\s*\w+)/';
    
    // Perform the regex search to capture "CODE: <actualcode>"
    if (preg_match($pattern, $text, $matches)) {
        // Full matched text, e.g., "CODE: thisishereacode"
        $fullCodeString = $matches[0];

        // Split the result using a space as the separator
        $parts = explode(' ', $fullCodeString);

        // Extract the actual code part
        $code = $parts[1] ?? "Code not found"; // Handle cases where code is missing

        // Return the full string and the extracted code separately
        return [
            'full_code_string' => $fullCodeString,
            'extracted_code' => $code
        ];
    } else {
        // If not found
        return [
            'full_code_string' => "Code not found.",
            'extracted_code' => "Code not found."
        ];
    }
}

// Example usage
$pdfFilePath = 'asdd.pdf'; // Replace with the actual path to your PDF
$result = extractAndProcessCode($pdfFilePath);

echo "Full Code String: " . $result['full_code_string'] . "\n";
echo "Extracted Code: " . $result['extracted_code'];
?>
