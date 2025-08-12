<?php
namespace App\Libraries;

class AIModerator
{
    public function checkInappropriate($text)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:11434/api/generate');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
            'model' => 'phi',  // ✅ use your actual model name
            'prompt' => "Think yourself as a blog moderator who do not allow inappropriated comments to be posted. Judge the text and find out whether the text is an appropriate comment. Answer BAD if inappropriate, GOOD if fine:\n\n$text",
            'stream' => false
        ]));

        $response = curl_exec($ch);
        curl_close($ch);

        if ($response) {
            log_message('error', 'AI Moderator: Response: ' . $response);  // Log the raw response

            $result = json_decode($response, true);

            if (isset($result['response'])) {
                $output = $result['response'];
                log_message('error', 'AI Moderator: Final output: ' . $output);

                if (stripos($output, 'BAD') !== false) {
                    return false; // Block comment
                }
                return true; // Allow comment
            } else {
                log_message('error', 'AI Moderator: Unexpected response content: ' . print_r($result, true));
            }
        } else {
            log_message('error', 'AI Moderator: No response from API');
        }

        // fallback: block if AI didn’t reply properly
        return false;
    }
}
