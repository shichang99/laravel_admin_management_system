<div class="relative form-input-box">

    <div class="form-input-label">{{ @$label ? $label : '' }}</div>
    @if (@$prefix)
    <div class="form-input-prefix" id="phone_prefix">{{ $prefix }}</div>
    @endif

    <input 
        type="{{ @$type ? $type : 'text' }}"
        name="{{ @$name ? $name : @$id }}"
        id="{{ @$id ? $id : @$name }}"
        placeholder="{{ @$placeholder ? $placeholder : 'Type Here...' }}"
        value="{{ @$value ? $value : old($name) }}"
        style="{{ @$style ? $style : '' }}"
        {{@!$disabled?'':'readonly'}}
      
    />
    @if (@$viewPassword == true)
    <div class="viewPassword">
        <i class="icon-icon6 closed-eye" onclick="viewPassword('{{ $id }}',this)"></i>
    </div>
    @endif

    @if (@$sendTac == true)
    <div class="sendTac" id="sendtac">SEND</div>
    @endif
</div>