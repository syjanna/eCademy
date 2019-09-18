-- to source this .sql file, type "source <directory to this file>" on mysql prompt on the cmd

DROP DATABASE IF EXISTS ecademydb;
CREATE DATABASE ecademydb;

USE ecademydb;


-- create tables
CREATE TABLE IF NOT EXISTS users(
  uname VARCHAR(100) NOT NULL PRIMARY KEY,
  password VARCHAR(100) NOT NULL,
  acc_type TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS courses(
  course_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  subject VARCHAR(50) NOT NULL,
  name VARCHAR(200) NOT NULL,
  instructor VARCHAR(100) NOT NULL,
  FOREIGN KEY (instructor) REFERENCES users(uname) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS units(
  unit_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(200) NOT NULL,
  course_id INT NOT NULL,
  FOREIGN KEY (course_id) REFERENCES courses(course_id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS lessons(
  lesson_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(200) NOT NULL,
  unit_id INT NOT NULL,
  course_id INT NOT NULL,
  lessonxml TEXT,
  quizxml TEXT,
  FOREIGN KEY (unit_id) REFERENCES units(unit_id) ON DELETE CASCADE,
  FOREIGN KEY (course_id) REFERENCES courses(course_id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS files(
  file_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  filename VARCHAR(200) NOT NULL,
  file MEDIUMBLOB,
  uname VARCHAR(100) NOT NULL,
  FOREIGN KEY (uname) REFERENCES users(uname) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS registration(
  course_id INT NOT NULL,
  student VARCHAR(100) NOT NULL,
  FOREIGN KEY(course_id) REFERENCES courses(course_id) ON DELETE CASCADE,
  FOREIGN KEY(student) REFERENCES users(uname) ON DELETE CASCADE
);


-- initialize values;
INSERT INTO users (uname, password, acc_type) VALUES(
  'songyijo',
  '8e21c895eb51358e6ce5723a03027f68',
  'instructor'
);

INSERT INTO courses (course_id, subject, name, instructor) VALUES(
  1,
  'COMPSCI',
  'Advanced Technologies for Web-Based Systems',
  'songyijo'
);

INSERT INTO units (unit_id, name, course_id) VALUES(
  1,
  'Introduction 1 - the Web, HTML5 and CSS',
  1
);

INSERT INTO units (unit_id, name, course_id) VALUES(
  2,
  'Introduction 2 - Client-side Scripting in JavaScript',
  1
);

INSERT INTO units (unit_id, name, course_id) VALUES(
  3,
  'XML and Ajax',
  1
);

-- note: when i initialize the table with values, i've used images stored in my local directories. however,
-- instructors can upload images of their own and use them with the <image> tag
INSERT INTO lessons (lesson_id, name, unit_id, course_id, lessonxml, quizxml) VALUES(
  1,
  'Web Servers',
  1,
  1,
  '<subsection>
    <subtitle> 1.1 Web Servers </subtitle>
    <text>
    A web server is a specialized software that responds to client requests, typically from a web browser.
    Whenever we try to go to a web page, we always provide a Uniform Resource Locator (URL) like www.google.com.
    When this happens, we are requesting a document from a web server. The server will map our URL to a resource/file on the
    server, then returns that resource to the client. The process of the request being sent from the client to the server is
    called a "GET" request, while the process of a response being sent back to the server from the client is called the HTTP response.
    </text>
    <text>
    Below are some images from the textbook that provide a visualization of the web client-server relationship.
    </text>
    <img src="../img/17.1.png"/> <image src="../img/17.2.png"/>
  </subsection>',
  '<question>
    <inquiry>What is the specialized software that responds to the client\'s requests?</inquiry>
    <answer>web server</answer>
    <choice>website</choice>
    <choice>web domain</choice>
    <choice>internet</choice>
  </question>
  <question>
    <inquiry>A link like www.youtube.com is also known as a URL, which stands for:</inquiry>
    <choice>United Resting Location</choice>
    <choice>Ur Resource Location</choice>
    <choice>Under Rated Lake</choice>
    <answer>Uniform Resource Locator</answer>
  </question>'
);


INSERT INTO lessons (lesson_id, name, unit_id, course_id, lessonxml, quizxml) VALUES(
  2,
  'HTML Fundamentals',
  1,
  1,
  '<subsection>
    <subtitle> 1.2 HTML Fundamentals </subtitle>
    <text>
    We will now review the fundamentals of HTML5. An HTML5 document adheres to the following structure:
    </text>
    <img src="../img/2.1.png"/>
    <text>
    An HTML5 document contains two parts to its structure: the document type declaration (DOCTYPE) and its elements.
    The DOCTYPE is an instruction that will associate the document with the document type definition (eg, HTML).
    There are three main HTML5 elements: the html, head, and body elements. The html element encloses the head and body
    elements. The head element usually contains the title, CSS style sheets, and scripts. The body element contains HTML
    code for the page\'s visual content.
    </text>
    <subsubsection> Start and end tags </subsubsection>
    <text>
      HTML code uses start and end tags to insert certain elements into the document. Start tags are enclosed by <>
      (&lt;html&gt;) while end tags are closed by &lt;/&gt; (&lt;/html&gt;). These tags often have attributes as well. A
      common element is the anchor element. For example, &lt;a href="google.com"&gt; link to google &lt;/a&gt;.
      \'a\' is the element name. \'href\' is an attribute which stands for hyperlink reference. The value of this attribute
      \'google.com\' is the link that this anchor element will link to when it\'s clicked on. The \'link to google\' is
      the text displayed on the HTML page which will link to google.com when it\'s clicked on.
    </text>
   </subsection>
   <subsection>
    <subtitle>Common elements</subtitle>
    <text>
      Besides the anchor element, there are other common elements in HTML5. Here are a few that were introduced from the textbook.
    </text>
    <subsubsection>Headings or paragraphs</subsubsection>
    <text>
      For headings, you can use &lth1&gt for the largest heading and &lth6&gt for the smallest heading. &ltp&gt are used to create paragraphs.
    </text>
    <subsubsection>Images</subsubsection>
    <text>
      Uses the &ltimg&gt tag. We can insert images into the document using an href attribute to provide a link to the image.
    </text>
    <subsubsection>Lists</subsubsection>
    <text>
      Can create ordered/numbered (&ltol&gt) and unordered/bulleted (&ltul&gt) lists. We specify each entry of an ordered/unordered list with the li element.
    </text>
    <subsubsection>Tables</subsubsection>
    <text>
      Uses the &lttable&gt tag. Tables are useful for displaying tabular data. In general, it is considered bad form to use
        HTML tables to create the visual layout of your page. Tables are a bit more complicated than the above
        elements to implement, but they always contain the thead, tbody, and tfoot elements. Also, they contain tr (table row)
        and th (table head column) elements which are defined in each of these elements. thead defines the names for the
        tr and th elements. tbody defines the primary data for the tr and th elements. Finally, tfoot is reserved for defining
        the data for the very bottom row of the table. As such, it usually contains calculation results and footnotes.
    </text>
    <subsubsection>Forms</subsubsection>
    <text>
      Another element commonly seen in HTML documents are forms. Below is an example of a form implementation, taken from the textbook:
    </text>
    <img src="../img/2.14.png"/>
    <text>
    A form contains a method and action attributes. The method attribute defines how the form\'s data is sent to the web server. This can either be
    POST (appending form data to the browser request and is transparent ie, user does not see the data after form is submitted) or GET (form
    data is appended to the end of the url of the script, and is visible to the data after submission). The action attribute specifies the url of
    a script on a web server that is invoked to process the form data.
    </text>
    <text>
    Forms also contain inputs. Inputs are defined by a type, which allows it to gather data in the form. For instance, an input of type "text" will
    display a textbox where the user can type input. Other examples of inputs include submit, reset, password and hidden input.
    We can also have checkbox and radio inputs, where the user is able to select options, and the form takes these selections as data. Checkboxes allow
    multiple selections by the user, and radio inputs allow only one selection by the user. One such example are multiple choice quizzes.
    Select inputs allow drop down lists, where the user is able to select an option from the list and send in as input data.
    </text>
   </subsection>',
  '<question>
  <inquiry>Which of the following elements does NOT belong in the HTML document?</inquiry>
  <choice>head</choice>
  <choice>html</choice>
  <choice>body</choice>
  <answer>blurb</answer>
  </question>
  <question>
  <inquiry>If you were to set the title tag for an HTML document, which part of the document would you place it in? </inquiry>
  <answer>head</answer>
  <choice>body</choice>
  <choice>script</choice>
  <choice>top</choice>
  </question>
  <question>
  <inquiry>How would you implement the end tag for &lthead&gt?</inquiry>
  <choice>&ltend&gt</choice>
  <answer>&lt/head&gt</answer>
  <choice>&lt/&gt</choice>
  <choice>&ltend/head&gt</choice>
  </question>
  <question>
  <inquiry>What is the name of the form attribute that defines where the data is sent to process the form data? </inquiry>
  <choice>src</choice>
  <choice>location</choice>
  <choice>url</choice>
  <answer>action</answer>
  </question>
  <question>
  <inquiry>The POST method of a form will append the data to the url of the script and is visible after submission.</inquiry>
  <choice>True</choice>
  <answer>False</answer>
  </question>
  <question>
  <inquiry>What is the name of the form attribute that allows you to define how the form\'s data is sent to the web server?</inquiry>
  <choice>mode</choice>
  <choice>input</choice>
  <choice>action</choice>
  <answer>method</answer>
  </question>'
);

INSERT INTO lessons (lesson_id, name, unit_id, course_id, lessonxml, quizxml) VALUES(
  3,
  'Advanced Topics in HTML5',
  1,
  1,
  '<subsection>
  <subtitle>1.3 Advanced Topics in HTML5</subtitle>
  <text>
    HTML5 introduces some new input types that can be used in documents. There are also self-validating input types that will check if the input matches
    the format associated with it with no additional coding required. Some self-validating input types and their expected formats include:
  </text>
  <text>- color : hexadecimal code</text>
  <text>- date : yyyy-mm-dd</text>
  <text>- month: yyyy-mm</text>
  <text>- email: name@domain.com</text>
  <text>- time: hh:mm</text>
  <text>
  Another interesting new element is the datalist element. The user can type in the textbox and as they type, the form will provide suggestions matching what the user
  has typed so far. The possible suggestions will be defined by the developer in the HTML document. In addition, there is an autocomplete attribute that can be
  used on input types to auto fill. Some of the page-structure related elements in HTML5 include:
  </text>
  <text>- header: create header for page, contains both text and graphics</text>
  <text>- figure and figcaption: describes a figure and provide a caption for it</text>
  <text>- article: describes content that could be used elsewhere, like a new article, forum post or blog entry</text>
  <text>- summary and details: creates a right pointing arrow next to a summary/caption. When it\'s clicked, the arrow points down and reveals contents in details</text>
  <text>- footer: adds a blurb at the bottom of the document</text>
  <text>- meter: displays a visual bar - eg, can be used to display survey results</text>
  <text>- mark and wbr: mark will highlight text, and wbr will break a word if the text wraps to multiple lines</text>
  </subsection>',
  '<question>
  <inquiry>The new input types introduced in HTML5 are:</inquiry>
  <choice>self-repairing</choice>
  <answer>self-validating</answer>
  <choice>self-documenting</choice>
  </question>
  <question>
  <inquiry>You can use the following element to highlight text: </inquiry>
  <choice>highlight</choice>
  <choice>emphasize</choice>
  <choice>important</choice>
  <answer>mark</answer>
  </question>
  <question>
  <inquiry>You can use the following element to break a word if the text wraps to multiple lines: </inquiry>
  <choice>wordbreak</choice>
  <choice>break</choice>
  <choice>unwrap</choice>
  <answer>wbr</answer>
  </question>'
);

INSERT INTO lessons (lesson_id, name, unit_id, course_id, lessonxml, quizxml) VALUES(
  4,
  'Introduction to Scripting',
  2,
  1,
  '<subsection>
  <subtitle>2.1 Introduction to Scripting</subtitle>
  <subsubsection> Implementation and variables </subsubsection>
  <text>
  JavaScript can be embedded in a JavaScript element using the &ltscript&gt tag with the attribute
  type set to "text/javascript". It can be placed in the head or body of the HTML document. Below is a sample
  implementation of JavaScript from the textbook.
  </text>
  <img src="../img/6.1.png"/>
  <text>
  Here, we have the script tag inside the head of the document. Notice in line 11, we use the document.writeln() statement.
  The document part refers to the document object in JavaScript, which is the HTML document that the browser is currently
  displaying. As in object-oriented programming, all objects have attributes and methods. In here, we use the writeln()
  function of the document object. This will write HTML code to the document, as seen above.
  There is also a write() function. Both write() and writeln() writes HTML code to the document, but writeln() will add
  a newline (\\n) to the end of the statement. <br/>
  There is also a function to gather user input in JavaScript.
  </text>
  <img src="../img/6.5.png"/>
  <text>
  In line 14, the window object is used, which refers to the popup box that appears on call, as seen above. Another function for
  the window object is the alert funciton. Figure 6.5 also shows how variables can be defined in Javascript. We use the var keyword
  to declare variables. Upon declaration, variables in JavaScript do not have a type associated with them. The variable type is
  decided once that variable has been assigned to a certain data type. For example, in line 11, the type is undefined. Once the
  window gathers user input in line 14, the type of the variable is decided to be a string. Some of the many data types that are used in
  JavaScript include integer, boolean, string and array.
  </text>
  <subsubsection>Equality and relational operators </subsubsection>
  <text>
  Below are the equality and relational operators that are used to compare variables in JavaScript:
  </text>
  <img src="../img/6.3.png"/>
  </subsection>',
  '<question>
  <inquiry>JavaScript can be inserted directly into the HTML document by using the following HTML tag: </inquiry>
  <choice>&ltJavaScript&gt</choice>
  <choice>&ltcode&gt</choice>
  <answer>&ltscript&gt</answer>
  <choice>&ltjavascript&gt</choice>
  </question>
  <question>
  <inquiry>When creating the HTML tag above, the attribute "type" should be set to the following value:</inquiry>
  <choice>code/javascript</choice>
  <answer>text/javascript</answer>
  <choice>code</choice>
  <choice>text</choice>
  </question>
  <question>
  <inquiry>document.writeln() will only write a newline, while document.write() will add text to the HTML document.</inquiry>
  <choice>true</choice>
  <answer>false</answer>
  </question>
  <question>
  <inquiry>When we want to create a popup box to display to the user, this window object is used:</inquiry>
  <answer>alert</answer>
  <choice>important</choice>
  <choice>alarm</choice>
  <choice>caution</choice>
  </question>
  <question>
  <inquiry>In JavaScript, variable types are determined when the variable is declared.</inquiry>
  <choice>true</choice>
  <answer>false</answer>
  </question>'
);



INSERT INTO lessons (lesson_id, name, unit_id, course_id, lessonxml, quizxml) VALUES(
  5,
  'Control Statements in JavaScript',
  2,
  1,
  '<subsection>
  <subtitle>2.2 Control Statements in JavaScript</subtitle>
  <text>
    Normally, JavaScript statements follow sequential execution, which means that one statement is executed after another, in order of the
    JavaScript file. However, there are JavaScript statements that lets the developer control the order of
    execution - this is known as transfer of control. There are 3 control structures and 8 control statements in total:
    sequence, selection (if, if...else, switch), and repetition (while, do...while, for, for...in).
    To examine how these control statements work, we will go over the if...else control statement.
  </text>
  <text>
  if (boolean) {
    do this
  } else {
    do this
  }
  </text>
  <text>
  The statement following the if must evaluate to a boolean. If the statement evaluates to true, then
  the code in the if block is executed. Else, if the statement evaluates to false, the code in the else
  block is executed.
  </p>
  </text>
  <subsubsection>Reserved keywords</subsubsection>
  <text>
  JavaScript has some reserved keywords. In programming languages, these are special words that cannot be used as an identifier, such
  as a variable or function. Generally, the keywords are reserved because they hold a meaning and are functionable in the code. However, this
  is not necessarily true as there are keywords that are reserved but are not used. Below is a table that lists the reserved keywords in
  JavaScript as well as the keywords that are reserved but not used in JavaScript.
  </text>
  <img src="../img/7.2.png"/>
  </subsection>',
  '<question>
  <inquiry>Which of the following is NOT a control statement in JavaScript?</inquiry>
  <choice>if...else</choice>
  <answer>for...all</answer>
  <choice>while</choice>
  <choice>for...in</choice>
  </question>
  <question>
  <inquiry>Normally, JavaScript statements execute one after another in order of the script. What is this type of execution called?</inquiry>
  <choice>one-way execution</choice>
  <choice>linear execution</choice>
  <choice>in-order execution</choice>
  <answer>sequential execution</answer>
  </question>
  <question>
  <inquiry>There are _ control structures and _ control statements. </inquiry>
  <choice>3, 7</choice>
  <choice>7, 3</choice>
  <answer>3, 8</answer>
  <choice>8, 3</choice>
  </question>
  <question>
  <inquiry>Some reserved keywords in JavaScripts are NOT used.</inquiry>
  <answer>true</answer>
  <choice>false</choice>
  </question>'
);

INSERT INTO lessons (lesson_id, name, unit_id, course_id, lessonxml, quizxml) VALUES(
  6,
  'Extended Markup Language (XML)',
  3,
  1,
  '<subsection>
  <subtitle>3.1 Extended Markup Language (XML)</subtitle>
  <text>
  XML is a portable, widely supported, open technology for data storage and usage.
  It allows the developer to create markup (text-based notation to describe data). It\'s very efficient
  to use and is also highly human and machine readable, making it a widely used technology.
  Below is an example of a simple XML document.
  </text>
  <img src="../img/15.1.png"/>
  <text>
  Notice that there is text enclosed by tags. The names in the tags represent element names, which is associated as the "data
  type" of the text that it encloses. For instance, we see in line 6, John is enclosed by firstName tags. Further, the entire block is
  enclosed by player tags. This means that the XML document is describing a "player" that contains "firstName", "lastName", and
  "battingAverage" elements. In this example, "player" is the root element. Note that every XML document must have exactly
  one root element that encloses all the other elements in the document.
  </text>
  <text>
  Also, note in the first line, we start with the XML declaration. All XML documents must start with this.
  XML documents are a text file that usually end with the .xml filename extension. An XML document requires an XML parser to be processed,
  which allows the document\'s data available to applications. To format data from XML documents, Extensible Stylesheet Language (XSL)
  can be used.
  </text>
  <subsubsection>Namespaces</subsubsection>
  <text>
  To prevent naming collisions (two elements that have the same name), XML namespaces are used. For example, imagine you have an element called
  "student" and you want to differentiate between medical school students and computer science students. This can be achived with namespace, as
  follows:
  </text>
  <text>
  -> &ltmedical:student&gt Frederick Grant Banting &lt/medical:student&gt
  </text>
  <text>
  -> &ltcompsci:student&gt Grace Hopper &lt/compsci:student&gt
  </text>
  <text>
  In these two examples, "medical" and "compsci" represent name space prefixes - the developer places this before the element name, separated
  by a single colon, to indicate which namespace the element belongs to. Each and every namespace prefix is bound to a Uniform Resource
  Identifier (URI), a series of characters which uniquely define the namespace.
  </text>
  <subsubsection> Schemas </subsubsection>
  <text>
  Schemas explain the relationships between a document\'s element types and attributes. They specify the requirements that should be met for each instance of
  that element. An example of a schema written as an .xsd document:
  </text>
  <img src="../img/15.10.png"/>
  <text>
  For example, in line 13, we have an element named "book". As specified in the xsd document, the "book" element must occur at least once and can occur
  for an unlimited number of times in the xml document. An xml document can be validated against its associated xsd document, meaning the validating software
  checks that each of these requirements for all elements are met in the xml document. An xml document must be considered valid by the validating software for it
  to successfully compile. Note that for all schemas, the root node must be "schema".
  </text>
  </subsection>',
  '<question>
  <inquiry>What does XML stand for?</inquiry>
  <choice>Extra Markup Language</choice>
  <choice>Extended Markup Learning</choice>
  <choice>Extended Modified Language</choice>
  <answer>Extended Markup Language</answer>
  </question>
  <question>
  <inquiry>Every XML document must have a single root node.</inquiry>
  <answer>true</answer>
  <choice>false</choice>
  </question>
  <question>
  <inquiry>To format data from XML documents, the following document type can be used:</inquiry>
  <choice>xsd</choice>
  <choice>txt</choice>
  <answer>xsl</answer>
  <choice>xml</choice>
  </question>
  <question>
  <inquiry>To describe the schema of an XML document, the following document can be used:</inquiry>
  <answer>xsd</answer>
  <choice>txt</choice>
  <choice>xsl</choice>
  <choice>xml</choice>
  </question>
  <question>
  <inquiry>XML namespaces should be placed after the element name.</inquiry>
  <choice>true</choice>
  <answer>false</answer>
  </question>
  <question>
  <inquiry>What must the root node be for all schemas?</inquiry>
  <choice>root</choice>
  <choice>main</choice>
  <choice>start</choice>
  <answer>schema</answer>
  </question>
  '
);

INSERT INTO lessons (lesson_id, name, unit_id, course_id, lessonxml, quizxml) VALUES(
  7,
  'Ajax and Ajax-enabled Rich Internet Applications',
  3,
  1,
  '<subsection>
  <subtitle>3.2 Ajax and Ajax-enabled Rich Internet Applications</subtitle>
  <subsubsection> Ajax Basics </subsubsection>
  <text>
    Ajax (Asynchronous JavaScript and XML) is a set of web application techniques that allow web applications to be asynchronous. This means that it sends requests
    to the server asynchronously - meaning that just a part of the application can be reloaded, rather than the entire page. That is, the user can interact with the page
    while the asynchronous request to the server is being processed. Of course, this makes web applications much more efficient and responsive. For example, on a form,
    you could click the submit button to send data over to the server. With Ajax however, you could validate each input of the form every time the user inserts input
    using the asynchronous requests. Below is a diagram that depicts the relationship between the client and the server with asynchronous requests:
  </text>
  <img src="../img/16.2.png"/>
  <subsubsection>XMLHttpRequest</subsubsection>
  <text>
  Ajax usually uses JavaScript\'s XMLHttpRequest object to manage its interactions with the server. Whenever the user interacts with the page, the client
  will create an XMLHttpRequest object to manage that request. This object will send the request to the server and wait for its response. Again, these requests are
  asynchronous, meaning the user can interact with the application while these requests run. The XMLHttpRequest object will invoke a callback function once the
  server sends a response, which usually uses partial page updates to display the data (without reloading the entire page).
  </text>
  </subsection>',
  '<question>
  <inquiry>What does Ajax stand for?</inquiry>
  <choice>Altered JavaScript and XML</choice>
  <choice>Arranged JavaScript and XML</choice>
  <choice>Asymmetrical JavaScript and XML</choice>
  <answer>Asynchronous JavaScript and XML</answer>
  </question>
  <question>
  <inquiry>With Ajax, the user is able to interact with the page while request(s) to the server are being processed.</inquiry>
  <answer>true</answer>
  <choice>false</choice>
  </question>
  <question>
  <inquiry>The following JavaScript object is commonly used to handle Ajax requests:</inquiry>
  <choice>XMLHttpObject</choice>
  <answer>XMLHttpRequest</answer>
  <choice>XMLRequest</choice>
  <choice>XMLObject</choice>
  </question>'
);
