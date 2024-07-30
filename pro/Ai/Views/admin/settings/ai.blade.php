@if(is_default_lang())
    <div class="panel">
        <div class="panel-title"><strong>{{__("OpenAI Settings")}}</strong></div>
        <div class="panel-body">
            <div class="form-group">
                <label class="">{{__("API Key")}}</label>
                <div class="form-controls">
                    <input
                        type="text" name="ai_api_key" value="{{ setting_item('ai_api_key') }}" class="form-control"
                    >
                </div>
                <p>
                    <i>
                        <a
                            href="https://www.maisieai.com/help/how-to-get-an-openai-api-key-for-chatgpt" target="_blank"
                        >How to get OpenAI api key
                        </a>
                    </i>
                </p>
            </div>
            <div class="form-group">
                <label class="">{{__("Model Name")}}</label>
                <div class="form-controls">
                    <input
                        type="text" name="ai_model_name" value="{{ setting_item('ai_model_name','gpt-3.5-turbo-1106') }}" class="form-control"
                    >
                </div>
            </div>
        </div>
    </div>
@endif
