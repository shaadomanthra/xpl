<div class="modal fade" id="terminated" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title text-danger" id="exampleModalLongTitle"><i class="fa fa-times-circle"></i> Exam Terminated</h3>
      
      </div>
      <div class="modal-body ">
       Due to the misconduct during the exam, the proctor has terminated your test. The responses saved till this point will be auto submitted.
      </div>
      
    </div>
  </div>
</div>


<div class="modal fade" id="io_code" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" >
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h3 class="modal-title text-info" id="exampleModalLongTitle"><i class="fa fa-bars"></i> Input/Output Instructions</h3>
      
      </div>
      <div class="modal-body ">
        <p>Click the language to see the I/O instructions</p>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="c-tab" data-toggle="tab" href="#c" role="tab" aria-controls="c" aria-selected="true">C</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="cpp-tab" data-toggle="tab" href="#cpp" role="tab" aria-controls="cpp" aria-selected="false">C++</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="csharp-tab" data-toggle="tab" href="#csharp" role="tab" aria-controls="csharp" aria-selected="false">C#</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="java-tab" data-toggle="tab" href="#java" role="tab" aria-controls="java" aria-selected="false">Java</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="python-tab" data-toggle="tab" href="#python" role="tab" aria-controls="python" aria-selected="false">Python</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="javascript-tab" data-toggle="tab" href="#javascript" role="tab" aria-controls="javascript" aria-selected="false">Javascript</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="php-tab" data-toggle="tab" href="#php" role="tab" aria-controls="php" aria-selected="false">PHP</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="ruby-tab" data-toggle="tab" href="#ruby" role="tab" aria-controls="ruby" aria-selected="false">Ruby</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="bash-tab" data-toggle="tab" href="#bash" role="tab" aria-controls="bash" aria-selected="false">Bash</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="swift-tab" data-toggle="tab" href="#swift" role="tab" aria-controls="swift" aria-selected="false">Swift</a>
  </li>
  
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="c" role="tabpanel" aria-labelledby="c-tab">
    <p class="mt-3">The testcase input is passed as command line arguments. In C programming, you can access the inputs using argv. </p>
    <pre><code>#include &lt;stdio.h>
#include &lt;stdlib.h>
int main (int argc, char *argv[]){
  // first input in string format
  printf("%s",argv[1]);
  // second input in interger format
  int arg2 = atoi(argv[2])
  printf("%d",arg2);
  // if there are 5 inputs, each can be accessed via argv[1] to argv[5]
}</code></pre>
  </div>
  <div class="tab-pane fade " id="cpp" role="tabpanel" aria-labelledby="cpp-tab">
    <p class="mt-3">The testcase input is passed as command line arguments. In C++, you can access the inputs using argv. </p>
    <pre><code>#include &lt;iostream> 
using namespace std; 
int main(int argc, char** argv) 
{ 
    // first input
    cout << argv[1] << "\n"; 
    //second input
    cout << argv[2] << "\n"; 
    return 0; 
} </code></pre>
  </div>
  <div class="tab-pane fade " id="csharp" role="tabpanel" aria-labelledby="cpp-tab">
    <p class="mt-3">The testcase input is passed as command line arguments. In C#, you can access the inputs using args. </p>
    <pre><code>using System;   
class Hello {   
 static void Main(string[] args)  
  {   
     // first input
      Console.WriteLine(args[0]); 
     // second input
     Console.WriteLine(args[1]); 
  }   
} </code></pre>
  </div>
  <div class="tab-pane fade " id="java" role="tabpanel" aria-labelledby="java-tab">
    <p class="mt-3">The testcase input is passed as command line arguments. In Java, you can access the inputs using args. </p>
    <div class="alert alert-important alert-danger">In java programming, the classname has to be named Main only.</div>
    <pre><code>class Main {
   public static void main(String args[]) {
      // first input in string format
      System.out.println(args[0]);
      // second input in integer format
      int arg2 = Integer.parseInt(args[1]);
      System.out.println(arg2);
      // if there are 5 inputs, each can be accessed via args[0] to args[4]
   }
} </code></pre>
  </div>
   <div class="tab-pane fade " id="python" role="tabpanel" aria-labelledby="python-tab">
    <p class="mt-3">The testcase input is passed as command line arguments. In Python, you can access the inputs using sys.argv. </p>
   
    <pre><code>import sys
# first input in string format
print(sys.argv[1])
# second input in integer format
arg2 = int(sys.argv[2])
print(arg2) 
# if there are 5 inputs, each can be accessed via sys.argv[1] to sys.argv[5]</code></pre>
  </div>
   <div class="tab-pane fade " id="javascript" role="tabpanel" aria-labelledby="javascript-tab">
    <p class="mt-3">The testcase input is passed as command line arguments. In Javascript, you can access the inputs using process.argv. </p>
   
    <pre><code>// first input
console.log(process.argv[2]);
// second input
console.log(process.argv[3]);</code></pre>
  </div>
   <div class="tab-pane fade " id="php" role="tabpanel" aria-labelledby="php-tab">
    <p class="mt-3">The testcase input is passed as command line arguments. In PHP, you can access the inputs using $argv. </p>
   
    <pre><code>&lt;?php  
echo $argv[1];  
echo $argv[2]; 
?&gt;</code></pre>
  </div>

  <div class="tab-pane fade " id="ruby" role="tabpanel" aria-labelledby="ruby-tab">
    <p class="mt-3">The testcase input is passed as command line arguments. In Ruby, you can access the inputs using ARGV. </p>
   
    <pre><code>
puts ARGV[0] 
puts ARGV[1]
    </code></pre>
  </div>

<div class="tab-pane fade " id="bash" role="tabpanel" aria-labelledby="bash-tab">
    <p class="mt-3">The testcase input is passed as command line arguments. In Bash, you can access the inputs using $1,$2. </p>
   
    <pre><code>
echo $1;
echo $2;
    </code></pre>
  </div>

  <div class="tab-pane fade " id="swift" role="tabpanel" aria-labelledby="swift-tab">
    <p class="mt-3">The testcase input is passed as command line arguments. In Swift, you can access the inputs using CommandLine.arguments. </p>
   
    <pre><code>
print(CommandLine.arguments[1])
print(CommandLine.arguments[2])
    </code></pre>
  </div>
  <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
</div>
      </div>
      
    </div>
  </div>
</div>