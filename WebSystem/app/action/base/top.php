<?php
    if(isset($req["login"]))
    {
        // Set the user's email address as the unique identifier
        $email = "user@example.com";

        // Generate a login request ID
        $request_id = bin2hex(random_bytes(16));

        // Create the login request object
        $request = array(
            "domain" => array("name" => "Your Application"),
            "loginProvider" => "torus",
            "redirect_uri" => $callback_url,
            "verifier" => "torus",
            "clientId" => $torus_api_key,
            "jwtParams" => array(
                "verifier_id_field" => "email",
                "email" => $email,
                "request_id" => $request_id,
                "network" => $network
            )
        );

        // Encode the login request object as JSON
        $request_json = json_encode($request);

        // Sign the JSON request with your Torus API secret
        $signature = hash_hmac("sha256", $request_json, $torus_api_secret);

        // Create the headers for the login request
        $headers = array(
            "Content-Type: application/json",
            "Authorization: ". $signature
        );

        // Send the login request to the Torus API endpoint
        $ch = curl_init($torus_endpoint);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        curl_close($ch);

        // Decode the login response JSON
        $response = json_decode($result, true);

        // Check if the login response is valid
        if(isset($response["type"]) && $response["type"] == "torus-authenticate-response") {
            // Redirect the user to the Torus widget for authentication
            page_move("/user__top/");
        } else {
            // Handle login error
            $error = "Login error";
        }
    }
?>