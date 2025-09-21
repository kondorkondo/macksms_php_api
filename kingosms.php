<?php require('kingosms-backend.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulk SMS Sender</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"], 
        textarea, 
        select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        textarea {
            height: 100px;
            resize: vertical;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #45a049;
        }
        #recipientList {
            height: 150px;
        }
        .status {
            margin-top: 20px;
            padding: 10px;
            border-radius: 4px;
        }
        .success {
            background-color: #dff0d8;
            color: #3c763d;
        }
        .error {
            background-color: #f2dede;
            color: #a94442;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Single - Bulk SMS Sender</h1>
        
        <form id="smsForm" action="kingosms.php" method="POST">
            <div class="form-group">
                <label for="senderId">Sender ID:</label>
                <input type="text" id="senderId" placeholder="Your company name" required>
            </div>
            
            <div class="form-group">
                <label for="recipients">Recipients:</label>
                <textarea id="recipientList" name="phone" placeholder="Enter phone number starting by 0 i.e 0712345678" required></textarea>
            </div>
            
            <div class="form-group">
                <label for="message">Message:</label>
                <textarea id="message" name="message" placeholder="Type your message here..." required></textarea>
                <div id="charCount">Characters: 0</div>
            </div>
            
            <div class="form-group">
                <button type="submit" name="send_single_sms">Send SMS</button>
            </div>
        </form>
        
        <div id="statusMessage" class="status" style="display: none;"></div>
        <div id="progressContainer" style="display: none;">
            <progress id="sendProgress" value="0" max="100"></progress>
            <span id="progressText">0%</span>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const messageInput = document.getElementById('message');
            const charCount = document.getElementById('charCount');
            const smsForm = document.getElementById('smsForm');
            const statusMessage = document.getElementById('statusMessage');
            const progressContainer = document.getElementById('progressContainer');
            const sendProgress = document.getElementById('sendProgress');
            const progressText = document.getElementById('progressText');
            
            // Character count update
            messageInput.addEventListener('input', function() {
                charCount.textContent = `Characters: ${this.value.length}`;
            });
            
            // Form submission
            /*
            smsForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const senderId = document.getElementById('senderId').value.trim();
                const recipientText = document.getElementById('recipientList').value.trim();
                const message = messageInput.value.trim();
                
                // Validate inputs
                if (!senderId || !recipientText || !message) {
                    showStatus('Please fill in all fields', 'error');
                    return;
                }
                
                // Process recipient list
                const recipients = recipientText.split(/[\n,]+/).map(num => num.trim()).filter(num => num);
                
                if (recipients.length === 0) {
                    showStatus('No valid phone numbers found', 'error');
                    return;
                }
                
                // Show progress
                progressContainer.style.display = 'block';
                sendProgress.max = recipients.length;
                sendProgress.value = 0;
                progressText.textContent = '0%';
                
                // Simulate sending (in a real app, this would be API calls)
                let successCount = 0;
                let errorCount = 0;
                
                recipients.forEach((recipient, index) => {
                    setTimeout(() => {
                        // Simulate API call delay
                        const isSuccess = Math.random() > 0.2; // 80% success rate for demo
                        
                        if (isSuccess) {
                            successCount++;
                        } else {
                            errorCount++;
                        }
                        
                        // Update progress
                        sendProgress.value = index + 1;
                        const percent = Math.round(((index + 1) / recipients.length) * 100);
                        progressText.textContent = `${percent}%`;
                        
                        // Final status
                        if (index === recipients.length - 1) {
                            showStatus(`Sent ${successCount} messages successfully. ${errorCount} failed.`, 
                                      errorCount === 0 ? 'success' : (successCount === 0 ? 'error' : ''));
                        }
                    }, index * 300); // Stagger requests
                });
            });
            */
            
            function showStatus(message, type) {
                statusMessage.textContent = message;
                statusMessage.className = 'status ' + type;
                statusMessage.style.display = 'block';
            }
        });
    </script>
</body>
</html>