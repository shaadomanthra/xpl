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
    <a class="nav-link" id="perl-tab" data-toggle="tab" href="#perl" role="tab" aria-controls="perl" aria-selected="false">Perl</a>
  </li>
  
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="c" role="tabpanel" aria-labelledby="c-tab">
    <p class="mt-3">The testcase input is passed as command line arguments. In C programming, you can access the inputs using argv. </p>
    <pre><code>#include &lt;stdio.h>
int main (int argc, char *argv[]){
  // first input
  printf("%s",argv[1]);
  // second input
  printf("%s",argv[2]);
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
      // first input
      System.out.println(args[0]);
      // second input
      System.out.println(args[1]);
   }
} </code></pre>
  </div>
   <div class="tab-pane fade " id="python" role="tabpanel" aria-labelledby="python-tab">
    <p class="mt-3">The testcase input is passed as command line arguments. In Python, you can access the inputs using sys.argv. </p>
   
    <pre><code>import sys
# first input
print(sys.argv[1])
# second input
print(sys.argv[2]) </code></pre>
  </div>
   <div class="tab-pane fade " id="javascript" role="tabpanel" aria-labelledby="javascript-tab">
    <p class="mt-3">The testcase input is passed as command line arguments. In Javascript, you can access the inputs using process.argv. </p>
   
    <pre><code>// first input
console.log(process.argv[2]);
// second input
console.log(process.argv[3]);</code></pre>
  </div>
   <div class="tab-pane fade " id="perl" role="tabpanel" aria-labelledby="perl-tab">
    <p class="mt-3">The testcase input is passed as command line arguments. In Perl, you can access the inputs using $ARGV. </p>
   
    <pre><code>$first_input=$ARGV[0];  
$second_input =$ARGV[1]; </code></pre>
  </div>
  <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
</div>
      </div>
      
    </div>
  </div>
</div>