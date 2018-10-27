@php
    $version = (!empty($version)) ? '/'.$version : '';
@endphp

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror{{$version}}/codemirror.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror{{$version}}/theme/monokai.min.css">
@endpush
@push('plugins')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror{{$version}}/codemirror.min.js"></script>
    <!-- Codemirror Libs -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror{{$version}}/mode/htmlmixed/htmlmixed.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror{{$version}}/mode/xml/xml.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror{{$version}}/mode/javascript/javascript.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror{{$version}}/mode/clike/clike.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror{{$version}}/mode/css/css.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror{{$version}}/mode/php/php.min.js"></script>
@endpush
@push('scripts')
<script>
    cmOptions = {
        tabSize: 4,
        readOnly: true,
        lineNumbers: true,
        mode: 'text/x-php',
        theme: "monokai",
        viewportMargin: Infinity,
        lineWrapping: true
    };
    cmHtmlOptions = {
        tabSize: 4,
        readOnly: true,
        lineNumbers: true,
        mode: 'text/html',
        theme: "monokai",
        viewportMargin: Infinity
    };
    let codeElements = document.getElementsByClassName( 'code');
    for (let codeElement of Array.from(codeElements)) {
        CodeMirror.fromTextArea(codeElement, cmOptions);
    }
    let codeHtmlElements = document.getElementsByClassName( 'htmlCode');
    for (let codeHtmlElement of Array.from(codeHtmlElements)) {
        CodeMirror.fromTextArea(codeHtmlElement, cmHtmlOptions);
    }
</script>
@endpush
