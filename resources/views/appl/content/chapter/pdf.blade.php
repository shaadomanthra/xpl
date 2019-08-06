 <html>
    <head>
        <style>
            /** 
                Set the margins of the page to 0, so the footer and the header
                can be of the full height and width !
             **/
            @page {
                margin: 0cm 0cm;
            }

            /** Define now the real margins of every page in the PDF **/
            body {
                margin-top: 2cm;
                margin-left: 2cm;
                margin-right: 2cm;
                margin-bottom: 2cm;
            }

            /** Define the header rules **/
            header {
                position: fixed;
                top: 0cm;
                left: 0cm;
                right: 0cm;
                height: 2cm;

                /** Extra personal styles **/
                background-color: #f8f8f8;
                color: white;
                line-height: 1cm;
            }

            /** Define the footer rules **/
            footer {
                position: fixed; 
                bottom: 0cm; 
                left: 0cm; 
                right: 0cm;
                height: 2cm;

                /** Extra personal styles **/
                background-color: #eee;
                color: #1f70ab;
                text-align: center;
                line-height: 1.5cm;
            }

            hr{ 
              height: 1px;
              color: red;
              background-color: #eee;
              border: none;
            }

            h3{
                color: #1f70ab;
            }
            .answer{
                color: #16a085;
            }
            i{
                color: #48dbfb;
            }
        </style>
    </head>
    <body>
        <!-- Define header and footer blocks before your content -->
        <header>
           <img src="https://packetprep.com/img/packetprep-logo-small.png" width="75px" class="logo-main ml-md-1" />
        </header>

        <footer>
            Copyright &copy; packetprep.com
        </footer>

        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
            
            @foreach($questions as $k => $question)
                <h3>{{$k+1}}. {!! $question->question!!}</h3>
                <div>(A) {{ strip_tags($question->a)}}</div>
                <div>(B) {{strip_tags($question->b)}}</div>
                <div>(C) {{strip_tags($question->c)}}</div>
                <div style="padding-bottom: 10px;">(D) {{strip_tags($question->d)}}</div>
                <div class="answer" >ANSWER : <b class="answer">{{$question->answer}}</b></div>
                <hr>
            @endforeach


        </main>
    </body>
</html>
