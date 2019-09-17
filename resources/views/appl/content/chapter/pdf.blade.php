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
                margin-top: 1cm;
                margin-left: 1cm;
                margin-right: 1cm;
                margin-bottom: 1cm;
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

            .question{
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
        

        <footer>
            Copyright &copy; packetprep.com - {{$topicname}}
        </footer>

        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
            
            @foreach($questions as $k => $question)
                <div class="question">{{$k+1}}. {!!  preg_replace('!^<p>(.*?)</p>$!i', '$1', $question->question) !!}</div>
                <div>
                    @if(strtoupper($question->answer)=='A')
                     <i>(A)</i>
                     @else
                     (A)
                    @endif 

                     {{ strip_tags($question->a)}} &nbsp; &nbsp;&nbsp;
                     @if(strtoupper($question->answer)=='B')
                     <i>(B)</i>
                     @else
                     (B)
                    @endif  {{strip_tags($question->b)}} &nbsp; &nbsp;&nbsp;
                     @if(strtoupper($question->answer)=='C')
                     <i>(C)</i>
                     @else
                     (C)
                    @endif {{strip_tags($question->c)}} &nbsp; &nbsp;&nbsp;
                     @if(strtoupper($question->answer)=='D')
                     <i>(D)</i>
                     @else
                     (D)
                    @endif 
                     {{strip_tags($question->d)}} 
                </div>
                <hr>
            @endforeach
        </main>
    </body>
</html>
