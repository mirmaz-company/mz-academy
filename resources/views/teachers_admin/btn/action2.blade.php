<button class="btn btn-primary btn-sm" onclick="send_email('{{ $data->email }}','{{ $data->id }}')" id="loader{{ $data->id }}">ارسال عبر الايميل</button>

<div class="spinner-border text-primary" role="status" id="loader2{{ $data->id }}" style="display: none">
    <span class="sr-only">Loading...</span>
  </div>