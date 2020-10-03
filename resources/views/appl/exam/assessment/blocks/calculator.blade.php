
    
    <link href="{{ asset('css/calculator.css') }}?new=13" rel="stylesheet">
    <style type="text/css">
        *.unselectable {
            -moz-user-select: -moz-none;
            -khtml-user-select: none;
            -webkit-user-select: none;

            /*
       Introduced in IE 10.
       See http://ie.microsoft.com/testdrive/HTML5/msUserSelect/
       */
            -ms-user-select: none;
            user-select: none;
        }
    </style>

<div class="modal fade" id="calculator" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="background-color: transparent;background: transparent; border: 0px solid transparent">

      <div class="">
<!-- Calculator -->
 <div id="keyPad" class="ui-widget-content calc_container">
        <!-- new Help changes -->
        <div id="helptopDiv">
            <span>Calculator</span>
            <button type="button"  class=" float-right" data-dismiss="modal" style="cursor: pointer;margin-top:-5px;">Close</button>
            
        </div>
        <!-- new Help changes -->
        <div class="calc_min" id="calc_min"></div>
        <!-- <div class="calc_max hide" id="calc_max"></div> -->
        <div class="calc_close" id="closeButton"></div>
        <!-- main content start here-->
        <div id="mainContentArea">
            <input type="text" id="keyPad_UserInput1" class="keyPad_TextBox1" readonly="" style="display: block;">
            <div class="text_container" style="display: inline;">
                <input type="text" id="keyPad_UserInput" class="keyPad_TextBox" maxlength="30" readonly="">
                <span id="memory" class="memoryhide">
                    <font size="2">M</font>
                </span>
            </div>
            <div class="clear"></div>
                <div class="left_sec">
            <div class="calc_row clear">
                <a href="#nogo" id="keyPad_btnMod" class="keyPad_btnBinaryOp" >mod</a>
                <div class="degree_radian">
                    <input type="radio" name="degree_or_radian" value="deg" checked="checked">Deg</input>
                    <input type="radio" name="degree_or_radian" value="rad">Rad</input>
                </div>
                <a href="#nogo" id="keyPad_MC" class="keyPad_btnMemoryOp">MC</a>
                <a href="#nogo" id="keyPad_MR" class="keyPad_btnMemoryOp">MR</a>
                <a href="#nogo" id="keyPad_MS"  class="keyPad_btnMemoryOp">MS</a>
                <a href="#nogo" id="keyPad_M+"  class="keyPad_btnMemoryOp">M+</a>
                <a href="#nogo" id="keyPad_M-" class="keyPad_btnMemoryOp">M-</a>
                
            </div>
            <div class="calc_row clear">
                <a href="#nogo" id="keyPad_btnSinH" class="keyPad_btnUnaryOp min">sinh</a>
                <a href="#nogo" id="keyPad_btnCosinH" class="keyPad_btnUnaryOp min">cosh</a>
                <a href="#nogo" id="keyPad_btnTgH" class="keyPad_btnUnaryOp min">tanh</a>
                <a href="#nogo" id="keyPad_btnAsinH" class="keyPad_btnUnaryOp min "><span class='baseele'>sinh</span><span class='superscript'>-1</span></a>
                <a href="#nogo" id="keyPad_btnAcosH" class="keyPad_btnUnaryOp min "><span class='baseele'>cosh</span><span class='superscript'>-1</span></a>
                <a href="#nogo" id="keyPad_btnAtanH" class="keyPad_btnUnaryOp min "><span class='baseele'>tanh</span><span class='superscript'>-1</span></a>
                <a href="#nogo" id="keyPad_btnPi" class="keyPad_btnConst">&#960;</a>
                <a href="#nogo" id="keyPad_btnE" class="keyPad_btnConst">e</a>
            </div>


            <div class="calc_row clear">
                <a href="#nogo" id="keyPad_btnSin" class="keyPad_btnUnaryOp min ">sin</a>
                <a href="#nogo" id="keyPad_btnCosin" class="keyPad_btnUnaryOp min">cos</a>
                <a href="#nogo" id="keyPad_btnTg" class="keyPad_btnUnaryOp min">tan</a>
                <a href="#nogo" id="keyPad_btnAsin" class="keyPad_btnUnaryOp min"><span class='baseele'>sin</span><span class='superscript'>-1</span></a>
                <a href="#nogo" id="keyPad_btnAcos" class="keyPad_btnUnaryOp min"><span class='baseele'>cos</span><span class='superscript'>-1</span></a>
                <a href="#nogo" id="keyPad_btnAtan" class="keyPad_btnUnaryOp min"><span class='baseele'>tan</span><span class='superscript'>-1</span></a>

                <a href="#nogo" id="keyPad_btnFact" class="keyPad_btnUnaryOp">n!</a>
                <a href="#nogo" id="keyPad_btnSquareRoot" class="keyPad_btnUnaryOp">
                    <div style="position: relative; top: 1px">&#8730;</div>
                </a>
            </div>

            

            <div class="calc_row clear">
                <a href="#nogo" id="keyPad_EXP" class="keyPad_btnBinaryOp">Exp</a>
                <a href="#nogo" id="keyPad_btnOpen" class="keyPad_btnBinaryOp ">(</a>
                <a href="#nogo" id="keyPad_btnClose" class="keyPad_btnBinaryOp ">)</a>
                <a href="#nogo" id="keyPad_btnBack" class="keyPad_btnCommand calc_arrows">
                    <div style="position: relative; top: -3px">&#8592;</div>
                </a>
                <a href="#nogo" id="keyPad_btnAllClr" class="keyPad_btnCommand ">C</a>
                <a href="#nogo" id="keyPad_btnInverseSign" class="keyPad_btnCommand " style="width:72px">+/-</a>
                
            </div>
            <div class="calc_row clear" style="margin-top: 5px;">
            
                <a href="#nogo" id="keyPad_btnLogBase2" class="keyPad_btnUnaryOp"><span class='baseele'>log</span><span class='subscript'>2</span><span class='baseele'>x</span></a>
                <a href="#nogo" id="keyPad_btnLn" class="keyPad_btnUnaryOp">ln</a>
                <a href="#nogo" id="keyPad_btnLg" class="keyPad_btnUnaryOp">log</a>         
                <a href="#nogo" id="keyPad_btn7" class="keyPad_btnNumeric">7</a>
                <a href="#nogo" id="keyPad_btn8" class="keyPad_btnNumeric">8</a>
                <a href="#nogo" id="keyPad_btn9" class="keyPad_btnNumeric ">9</a>
                <a href="#nogo" id="keyPad_btnDiv" class="keyPad_btnBinaryOp">/</a>
                <a href="#nogo" id="keyPad_%" class="keyPad_btnBinaryOp">%</a>
            </div>
            <div class="calc_row clear">
            
                <a href="#nogo" id="keyPad_btnYlogX" class="keyPad_btnBinaryOp "><span class='baseele'>log</span><span class='subscript'>y</span><span class='baseele'>x</span></a>
                <a href="#nogo" id="keyPad_btnExp" class="keyPad_btnUnaryOp"><span class='baseele'>e</span><span class='superscript'>x</span></a>
                <a href="#nogo" id="keyPad_btn10X" class="keyPad_btnUnaryOp"><span class='baseele'>10</span><span class='superscript'>x</span></a>
            
                
                <a href="#nogo" id="keyPad_btn4" class="keyPad_btnNumeric">4</a>
                <a href="#nogo" id="keyPad_btn5" class="keyPad_btnNumeric">5</a>
                <a href="#nogo" id="keyPad_btn6" class="keyPad_btnNumeric ">6</a>
                <a href="#nogo" id="keyPad_btnMult" class="keyPad_btnBinaryOp"><div style="position: relative; top: 3px; font-size: 20px">*</div></a>
                <a href="#nogo" id="keyPad_btnInverse" class="keyPad_btnUnaryOp"><span class='baseele'>1/x</span></a>
            </div>
            <div class="calc_row clear">
                
                <a href="#nogo" id="keyPad_btnYpowX" class="keyPad_btnBinaryOp"><span class='baseele'>x</span><span class='superscript'>y</span></a>
                <a href="#nogo" id="keyPad_btnCube" class="keyPad_btnUnaryOp"><span class='baseele'>x</span><span class='superscript'>3</span></a>
                <a href="#nogo" id="keyPad_btnSquare" class="keyPad_btnUnaryOp"><span class='baseele'>x</span><span class='superscript'>2</span></a>
                <a href="#nogo" id="keyPad_btn1" class="keyPad_btnNumeric">1</a>
                <a href="#nogo" id="keyPad_btn2" class="keyPad_btnNumeric">2</a>
                <a href="#nogo" id="keyPad_btn3" class="keyPad_btnNumeric">3</a>
                <a href="#nogo" id="keyPad_btnMinus" class="keyPad_btnBinaryOp"><div style="position: relative; top: -1px; font-size: 20px">-</div></a>
            </div>
            <div class="calc_row clear">
                
                <a href="#nogo" id="keyPad_btnYrootX" class="keyPad_btnBinaryOp"><span class='superscript' style='top: -8px;'>y</span><span class='baseele' style='font-size: 1.2em; margin: -6px 0 0 -9px;'>&#8730;x</span></a>
                <a href="#nogo" id="keyPad_btnCubeRoot" class="keyPad_btnUnaryOp"><font size="3">&#8731; </font></a>
                <a href="#nogo" id="keyPad_btnAbs" class="keyPad_btnUnaryOp"><span class='baseele'>|x|</span></a>
                <a href="#nogo" id="keyPad_btn0" class="keyPad_btnNumeric">0</a>
                <a href="#nogo" id="keyPad_btnDot" class="keyPad_btnNumeric ">.</a>
                <a href="#nogo" id="keyPad_btnPlus" class="keyPad_btnBinaryOp">+</a>
                <a href="#nogo" id="keyPad_btnEnter" class="keyPad_btnCommand "><div style="margin-bottom: 2px;">=</div></a>
            </div>
        </div>
            <div class="clear"></div>
            <!-- main content end here-->
        </div>
    </div>
<!-- end -->
      </div>
    
    </div>
  </div>
</div>