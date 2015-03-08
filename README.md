## Instructions

1. Include `bbcode.php`
2. Instantiate the `BBCode` class
3. Execute the `toHTML` method on a string which contains BBCode (optionally pass `false` as the second argument to allow special html chars like "\<html_tag\>...\</html_tag\>")
4. Enjoy HTML output

## Example Code

```php
<?php
require "bbcode.php";

$text=<<<EOF

[br]

[b]This is bold text[/b]

[i]This is italic text[/i]

[p]this is a paragraph - some text goes here...[/p]

[code]This is pre-formatted text[/code]

[quote]This is a quote[/quote]

[quote="Obama"]This is a quote by a specific person[/quote]

[quote cite="https://www.google.com"]This is a quote[/quote]

[quote="Obama" cite="https://www.google.com"]This is a quote by a specific person[/quote]

[quote name="Obama"]This is a quote by a specific [q]person[/q][/quote]

[quote name="Obama" cite="https://www.google.com"]This is a quote by a specific person[/quote]

[size=30]This text's size is set at 30pt[/size]

[s]This text has a strikethrough[/s]

[u]This text is underlined.[/u]

[left]This text is to the left[/left]

[center]This text is centered[/center]

[right]This text is to the right[/right]

[color=red]This is red text[/color]

[email]someone@somewhere.com[/email]

[email=someone@somewhere.com]An e-mail link[/email]

[email subject=my subject]someone@somewhere.com[/email]

[email=someone@somewhere.com subject=my subject]An e-mail link with subject[/email]

[url]http://www.google.com/[/url]

[url=http://www.google.com/]Google.com yo![/url]

[img]http://i.imgur.com/WqYEO.jpg[/img]

An image as a link:

[url=http://en.wikipedia.org/wiki/Ninja][img]http://i.imgur.com/8d7Yu.jpg[/img][/url]

This is an unordered list: 

[list]
[*]list item #1
[*]list item #2
[*][b]bold list item #3[/b]
[/list]

This is an ordered (numbered) list: 

[list=1]
[*]list item #1
[*]list item #2
[*][b]bold list item #3[/b]
[/list]

This is an ordered (alpha) list: 

[list=a]
[*]list item #1
[*]list item #2
[*][b]bold list item #3[/b]
[/list]

[youtube]oRdxUFDoQe0[/youtube]

[youtube size=520X415]oRdxUFDoQe0[/youtube]

[youtube]https://www.youtube.com/watch?v=oRdxUFDoQe0[/youtube]

[youtube size=520X415]https://www.youtube.com/watch?v=oRdxUFDoQe0[/youtube]


EOF;

$bbcode = new BBCode;

//will close unclosed bbcode tags.
$formated_BBcode = $bbcode->checkTag($text);

echo $bbcode->toHTML($formated_BBcode);  

?>
```

## Example Output

```html

<br/>

<strong>This is bold text</strong>

<em>This is italic text</em>

<p>this is a paragraph - some text goes here...</p>

<pre><code>This is pre-formatted text</code><pre>

<blockquote><p>This is a quote</p></blockquote>

Obama wrote: <blockquote><p>This is a quote by a specific person</p></blockquote>

<blockquote cite="https://www.google.com"><p>This is a quote</p></blockquote>

Obama wrote: <blockquote><p>This is a quote by a specific <q>person</q></p></blockquote>

Obama wrote: <blockquote cite="https://www.google.com"><p>This is a quote by a specific person</p></blockquote>

<span style="font-size:30%">This text's size is set at 30%</span>

<del>This text has a strikethrough</del>

<span style="text-decoration:underline;">This text is underlined.</span>

<div style="text-align:left;">This text is centered</div>

<div style="text-align:center;">This text is centered</div>

<div style="text-align:right;">This text is centered</div>

<span style="color:red;">This is red text</span>

<a href="mailto:someone@somewhere.com">someone@somewhere.com</a>

<a href="mailto:someone@somewhere.com">An e-mail link</a>

<a href="mailto:someone@somewhere.com?subject=my subject">someone@somewhere.com</a>

<a href="mailto:someone@somewhere.com?subject=my subject">An e-mail link with subject</a>

<a href="http://www.google.com/">http://www.google.com/</a>

<a href="http://www.google.com/">Google.com yo!</a>

<img src="http://i.imgur.com/WqYEO.jpg"/>

An image as a link:

<a href="http://en.wikipedia.org/wiki/Ninja"><img src="http://i.imgur.com/8d7Yu.jpg"/></a>

This is an unordered list: 

<ul><li>list item #1</li><li>list item #2</li><li><strong>bold list item #3</strong></li></ul>

This is an ordered (numbered) list: 

<ol><li>list item #1</li><li>list item #2</li><li><strong>bold list item #3</strong></li></ol>

This is an ordered (alpha) list: 

<ol style="list-style-type: lower-alpha;"><li>list item #1</li><li>list item #2</li><li><strong>bold list item #3</strong></li></ol>

<iframe width="420" height="315" src="https://www.youtube.com/embed/oRdxUFDoQe0" frameborder="0" allowfullscreen></iframe>

<iframe width="520" height="415" src="https://www.youtube.com/embed/oRdxUFDoQe0" frameborder="0" allowfullscreen></iframe>

<iframe width="420" height="315" src="https://www.youtube.com/embed/oRdxUFDoQe0" frameborder="0" allowfullscreen></iframe>

<iframe width="520" height="415" src="https://www.youtube.com/embed/oRdxUFDoQe0" frameborder="0" allowfullscreen></iframe>


```
