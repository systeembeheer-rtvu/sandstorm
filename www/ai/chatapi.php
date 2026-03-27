<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>ChatGPT Prompt Tool</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
  >
  <style>
    textarea {
      resize: vertical;
    }
  </style>
</head>
<body>
  <div class="container my-5">
    <h1 class="mb-4">ChatGPT Prompt Tool</h1>

    <div class="mb-3">
      <label for="instruction" class="form-label">Instruction</label>
      <textarea class="form-control" id="instruction" rows="5" placeholder="e.g. Summarize this text"></textarea>
      <div class="form-text">
        A short instruction or full prompt. Example: "Summarize this", "Translate to Dutch", or a custom task.
      </div>
    </div>

    <div class="mb-3">
      <label for="inputData" class="form-label">Input Text</label>
      <textarea class="form-control" id="inputData" rows="8" placeholder="Paste your content here..."></textarea>
      <div class="form-text">
        This is the content you want ChatGPT to work on (text to summarize, translate, etc.).
      </div>
    </div>

    <div class="mb-3">
      <label for="model" class="form-label">Model</label>
      <select class="form-select" id="model">
        <option value="gpt-3.5-turbo">gpt-3.5-turbo – Fast, affordable</option>
        <option value="gpt-4">gpt-4 – Smarter, slower, more expensive</option>
        <option value="gpt-4o">gpt-4o – Fast + smart (recommended)</option>
      </select>
      <div class="form-text">
        Choose the GPT model to use.
      </div>
    </div>

    <div class="row">
      <div class="col-md-6 mb-3">
        <label for="temperature" class="form-label">Temperature</label>
        <input type="number" class="form-control" id="temperature" value="1.0" step="0.1" min="0" max="2">
        <div class="form-text">
          Controls randomness. 0 = precise, 1 = creative, 2 = very random.
        </div>
      </div>
      <div class="col-md-6 mb-3">
        <label for="max_tokens" class="form-label">Max Tokens</label>
        <input type="number" class="form-control" id="max_tokens" value="500">
        <div class="form-text">
          Max response length. 500 tokens ≈ 375 words.
        </div>
      </div>
    </div>

    <div class="mb-3">
      <label for="systemPrompt" class="form-label">System Prompt</label>
      <input type="text" class="form-control" id="systemPrompt" value="You are a helpful assistant.">
      <div class="form-text">
        Defines assistant behavior/tone. Example: "You are a sarcastic but correct AI."
      </div>
    </div>

    <div class="mb-4">
      <button class="btn btn-primary" onclick="callChatGPT()">Submit</button>
    </div>

    <div class="mb-3">
      <label for="response" class="form-label">Response</label>
      <textarea class="form-control" id="response" rows="10" readonly></textarea>
    </div>
  </div>

  <script>
    const fields = ['instruction', 'inputData', 'model', 'temperature', 'max_tokens', 'systemPrompt'];

    function loadValuesFromStorage() {
      fields.forEach(field => {
        const el = document.getElementById(field);
        const stored = localStorage.getItem(`chatgpt_${field}`);
        if (el && stored !== null) {
          if (el.type === 'number') {
            el.value = parseFloat(stored);
          } else {
            el.value = stored;
          }
        }
      });
    }

    function saveValuesToStorage() {
      fields.forEach(field => {
        const el = document.getElementById(field);
        if (el) localStorage.setItem(`chatgpt_${field}`, el.value);
      });
    }

    function setupAutoSave() {
      fields.forEach(field => {
        const el = document.getElementById(field);
        if (el) el.addEventListener('input', saveValuesToStorage);
      });
    }

    async function callChatGPT() {
      const instruction = document.getElementById('instruction').value.trim();
      const inputData = document.getElementById('inputData').value.trim();
      const model = document.getElementById('model').value;
      const temperature = parseFloat(document.getElementById('temperature').value);
      const max_tokens = parseInt(document.getElementById('max_tokens').value);
      const systemPrompt = document.getElementById('systemPrompt').value.trim();
      const responseBox = document.getElementById("response");

      if (!instruction || !inputData) {
        alert("Please enter both an instruction and input text.");
        return;
      }

      saveValuesToStorage();

      const userMessage = instruction + "\n\n" + inputData;

      responseBox.value = "Loading...";

      try {
        const res = await fetch("chatapi_proxy.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({
            model,
            temperature,
            max_tokens,
            messages: [
              { role: "system", content: systemPrompt },
              { role: "user", content: userMessage }
            ]
          })
        });

        const data = await res.json();
        responseBox.value = data.choices?.[0]?.message?.content || "No response.";
      } catch (err) {
        responseBox.value = "Error: " + err.message;
      }
    }

    loadValuesFromStorage();
    setupAutoSave();
  </script>
</body>
</html>
