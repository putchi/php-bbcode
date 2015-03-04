<?php

/**
 * BBCode to HTML converter
 *
 * Inspired by Kai Mallea (kmallea@gmail.com)
 *
 * Licensed under the MIT license: http://www.opensource.org/licenses/mit-license.php
 */
class BBCode {

    protected $bbcode_table = array();

    public function __construct() {

        // Replace [br] with <br />
        $this->bbcode_table["/\[br\]/is"] = function ($match) {
            return "<br/>";
        };


        // Replace [p]...[/p] with <p>...</p>
        $this->bbcode_table["/\[p\](.*?)\[\/p\]/is"] = function ($match) {
            return "<p>$match[1]</p>";
        };


        // Replace [b]...[/b] with <strong>...</strong>
        $this->bbcode_table["/\[b\](.*?)\[\/b\]/is"] = function ($match) {
            return "<strong>$match[1]</strong>";
        };


        // Replace [i]...[/i] with <em>...</em>
        $this->bbcode_table["/\[i\](.*?)\[\/i\]/is"] = function ($match) {
            return "<em>$match[1]</em>";
        };


        // Replace [q]...[/q] with <q>...</q>
        $this->bbcode_table["/\[q\](.*?)\[\/q\]/is"] = function ($match) {
            return "<q>$match[1]</q>";
        };


        // Replace [code]...[/code] with <pre><code>...</code></pre>
        $this->bbcode_table["/\[code\](.*?)\[\/code\]/is"] = function ($match) {
            return "<pre><code>$match[1]</code></pre>";
        };


        // Replace [quote]...[/quote] with <blockquote><p>...</p></blockquote>
        $this->bbcode_table["/\[quote\](.*?)\[\/quote\]/is"] = function ($match) {
            return "<blockquote><p>$match[1]</p></blockquote>";
        };


        // Replace [quote cite="some cite source"]...[/quote] with <blockquote cite="some cite source"><p>...</p></blockquote>
        $this->bbcode_table["/\[quote cite=\"([^\"]+)\"\](.*?)\[\/quote\]/is"] = function ($match) {
            return "<blockquote cite=\"$match[1]\"><p>$match[2]</p></blockquote>";
        };

        // Replace [quote name="person"]...[/quote] with person wrote: <blockquote><p>...</p></blockquote>
        $this->bbcode_table["/\[quote name=\"([^\"]+)\"\](.*?)\[\/quote\]/is"] = function ($match) {
            return "<span class=\"author\">$match[1] wrote:</span><br/><blockquote><p>$match[2]</p></blockquote>";
        };


        // Replace [quote name="person" cite="some cite source"]...[/quote] with person wrote: <blockquote cite="some cite source"><p>...</p></blockquote>
        $this->bbcode_table["/\[quote name=\"([^\"]+)\" cite=\"([^\"]+)\"\](.*?)\[\/quote\]/is"] = function ($match) {
            return "<span class=\"author\">$match[1] wrote:</span><br/><blockquote cite=\"$match[2]\"><p>$match[3]</p></blockquote>";
        };


        // OR:
        // // Replace [quote=person]...[/quote] with <blockquote><p>...</p></blockquote>
        // $this->bbcode_table["/\[quote=(.+?)\](.*?)\[\/quote\]/is"] = function ($match) {
        //   return "$match[1] wrote: <blockquote><p>$match[2]</p></blockquote>";
        // };
        // Replace [size=30]...[/size] with <span style="font-size:30pt">...</span>
        $this->bbcode_table["/\[size=(\d+)\](.*?)\[\/size\]/is"] = function ($match) {
            return "<span style=\"font-size:$match[1]pt;\">$match[2]</span>";
        };


        // Replace [s] with <del>
        $this->bbcode_table["/\[s\](.*?)\[\/s\]/is"] = function ($match) {
            return "<del>$match[1]</del>";
        };


        // Replace [u]...[/u] with <span style="text-decoration:underline;">...</span>
        $this->bbcode_table["/\[u\](.*?)\[\/u\]/is"] = function ($match) {
            return '<span style="text-decoration:underline;">' . $match[1] . '</span>';
        };


        // Replace [left]...[/left] with <div style="text-align:left;">...</div>
        $this->bbcode_table["/\[left\](.*?)\[\/left\]/is"] = function ($match) {
            return '<div style="text-align:left;">' . $match[1] . '</div>';
        };


        // Replace [center]...[/center] with <div style="text-align:center;">...</div>
        $this->bbcode_table["/\[center\](.*?)\[\/center\]/is"] = function ($match) {
            return '<div style="text-align:center;">' . $match[1] . '</div>';
        };


        // Replace [right]...[/right] with <div style="text-align:right;">...</div>
        $this->bbcode_table["/\[right\](.*?)\[\/right\]/is"] = function ($match) {
            return '<div style="text-align:right;">' . $match[1] . '</div>';
        };


        // Replace [color=somecolor]...[/color] with <span style="color:somecolor;">...</span>
        $this->bbcode_table["/\[color=([#a-z0-9]+)\](.*?)\[\/color\]/is"] = function ($match) {
            return '<span style="color:' . $match[1] . ';">' . $match[2] . '</span>';
        };


        // Replace [email]...[/email] with <a href="mailto:...">...</a>
        $this->bbcode_table["/\[email\](.*?)\[\/email\]/is"] = function ($match) {
            return "<a href=\"mailto:$match[1]\">$match[1]</a>";
        };


        // Replace [email=someone@somewhere.com]An e-mail link[/email] with <a href="mailto:someone@somewhere.com">An e-mail link</a>
        $this->bbcode_table["/\[email=(.*?)\](.*?)\[\/email\]/is"] = function ($match) {
            return "<a href=\"mailto:$match[1]\">$match[2]</a>";
        };


        // Replace [url]...[/url] with <a href="...">...</a>
        $this->bbcode_table["/\[url\](.*?)\[\/url\]/is"] = function ($match) {
            return "<a href=\"$match[1]\">$match[1]</a>";
        };


        // Replace [url=http://www.google.com/]A link to google[/url] with <a href="http://www.google.com/">A link to google</a>
        $this->bbcode_table["/\[url=(.*?)\](.*?)\[\/url\]/is"] = function ($match) {
            return "<a href=\"$match[1]\">$match[2]</a>";
        };


        // Replace [img]...[/img] with <img src="..."/>
        $this->bbcode_table["/\[img\](.*?)\[\/img\]/is"] = function ($match) {
            return "<img src=\"$match[1]\"/>";
        };


        // Replace [img alt="..."]...[/img] with <img src="..." alt="..." />
        $this->bbcode_table["/\[img alt=\"([^\"]+)\"\](.*?)\[\/img\]/is"] = function ($match) {
            return "<img src=\"$match[2]\" alt=\"$match[1]\"/>";
        };

        // Replace [list]...[/list] with <ul><li>...</li></ul>
        $this->bbcode_table["/\[list\](.*?)\[\/list\]/is"] = function ($match) {
            $match[1] = preg_replace_callback("/\[\*\]([^\[\*\]]*)/is", function ($submatch) {
                return "<li>" . preg_replace("/[\n\r?]$/", "", $submatch[1]) . "</li>";
            }, $match[1]);

            return "<ul>" . preg_replace("/[\n\r?]/", "", $match[1]) . "</ul>";
        };


        // Replace [list=1|a]...[/list] with <ul|ol><li>...</li></ul|ol>
        $this->bbcode_table["/\[list=(1|a)\](.*?)\[\/list\]/is"] = function ($match) {
            if ($match[1] == '1') {
                $list_type = '<ol>';
            } else if ($match[1] == 'a') {
                $list_type = '<ol style="list-style-type: lower-alpha;">';
            } else {
                $list_type = '<ol>';
            }

            $match[2] = preg_replace_callback("/\[\*\]([^\[\*\]]*)/is", function ($submatch) {
                return "<li>" . preg_replace("/[\n\r?]$/", "", $submatch[1]) . "</li>";
            }, $match[2]);

            return $list_type . preg_replace("/[\n\r?]/", "", $match[2]) . "</ol>";
        };


        // Replace [youtube]...[/youtube] with <iframe src="..."></iframe>
        $this->bbcode_table["/\[youtube\](?:https?:\/\/)?(?:www\.)?youtube(?:\.com\/watch\?v=)([A-Z0-9\-_]+)(?:&(.*?))?\[\/youtube\]/is"] = function ($match) {
            return "<iframe width=\"420\" height=\"315\" src=\"https://www.youtube.com/embed/$match[1]\" frameborder=\"0\" allowfullscreen></iframe>";
        };


        // Alternative: Replace [youtube]...[/youtube] with <iframe src="..."></iframe>
        $this->bbcode_table["/\[youtube\]([a-zA-Z0-9\-_]+)\[\/youtube\]/is"] = function ($match) {
            return "<iframe width=\"420\" height=\"315\" src=\"https://www.youtube.com/embed/$match[1]\" frameborder=\"0\" allowfullscreen></iframe>";
        };


        // Replace [youtube size=111X333]...[/youtube] with <iframe src="..."></iframe>
        $this->bbcode_table["/\[youtube size=([0-9]{1,4}+)X([0-9]{1,4}+)\](?:https?:\/\/)?(?:www\.)?youtube(?:\.com\/watch\?v=)([A-Z0-9\-_]+)(?:&(.*?))?\[\/youtube\]/is"] = function ($match) {
            return "<iframe width=\"$match[1]\" height=\"$match[2]\" src=\"https://www.youtube.com/embed/$match[3]\" frameborder=\"0\" allowfullscreen></iframe>";
        };


        // Alternative: Replace [youtube size=111X333]...[/youtube] with <iframe src="..."></iframe>
        $this->bbcode_table["/\[youtube size=([0-9]{1,4}+)X([0-9]{1,4}+)\]([a-zA-Z0-9\-_]+)\[\/youtube\]/is"] = function ($match) {
            return "<iframe width=\"$match[1]\" height=\"$match[2]\" src=\"https://www.youtube.com/embed/$match[3]\" frameborder=\"0\" allowfullscreen></iframe>";
        };
    }

    public function checkTag(
    $_str
    ) {
        $_index = 0;
        $_stack = [];
        $_value = '';
        $_property = '';

        $i = 0;
        $l = strlen($_str);

        while ($i < $l) {
            // this searches for an opening tag
            if ($_str[$i] === '[') {
                $_tag = '';
                $_newtag = '';
                while (++$i < $l && $_str[$i] !== ']') {
                    $_tag .= $_str[$i];
                }
                // this searches for a closing a tag
                if ($_tag[0] === '/') {
                    $_tag = strtolower(substr($_tag, 1));

                    $_index --;

                    while ($_index >= 0 && $_stack[$_index] !== $_tag) {
                        $_value .= $this->tagEncodeClosed($_stack[$_index]);

                        $_index --;
                    }

                    if ($_index === -1) {
                        return $_value;
                    }

                    $_value .= $this->tagEncodeClosed($_stack[$_index]);
                } else {
                    // here it starts building the tag
                    $_tagCheck = $this->tagEncodeExclusive($_tag);

                    //if an exclusive tag was found
                    if ($_tagCheck !== null) {
                        $_value .= $_tagCheck;
                    } else {
                        $_tag = preg_split("/\s+/", $_tag);

                        $_tag[0] = strtolower($_tag[0]);

                        $_tmpTag = $_tag[0];

                        $j = 0;
                        while ($j < strlen($_tmpTag) && $_tmpTag[$j] !== '=') {
                            $_newtag .= $_tmpTag[$j];
                            $j ++;
                        }
                        //if there is a property it will add it to the tag
                        while ($j < strlen($_tmpTag)) {
                            $_property .= $_tmpTag[$j];
                            $j ++;
                        }

                        $_value .= $this->tagEncode($_newtag, array_slice($_tag, 1), "", $_property);
                        // resetting the property
                        $_property = "";

                        $_stack[$_index ++] = $_newtag;
                    }
                }
            } else {
                $_value .= $_str[$i];
            }

            $i ++;
        }

        $_index --;
        // closing all tags that are not closed
        while ($_index >= 0) {
            $_value .= $this->tagEncodeClosed($_stack[$_index]);

            $_index --;
        }
        
        return $_value;
    }

    protected function tagEncodeExclusive(
    $_tag
    ) {
        switch ($_tag) {
            case "br":
                return "[br]";

            case "*":
                return "[*]";
        }

        return null;
    }
    
    protected function tagEncode(
    $_tag, $_arguments = null, $_closed = "", $_property = ""
    ) {
        $_val = null;

        switch ($_tag) {
            case "b":
                $_val = "b";
                break;
            case "i":
                $_val = "i";
                break;
            case 's':
                $_val = "s";
                break;
            case 'u':
                $_val = "u";
                break;
            case 'q':
                $_val = "q";
                break;
            case 'p':
                $_val = "p";
                break;
            case 'code':
                $_val = "code";
                break;
            case 'email':
                $_val = "email";
                break;
            case 'url':
                $_val = "url";
                break;
            case 'img':
                $_val = "img";
                break;
            case 'quote':
                $_val = "quote";
                break;
            case 'youtube':
                $_val = "youtube";
                break;
            case 'font':
                $_val = "font";
                break;
            case 'size':
                $_val = "size";
                break;
            case 'color':
                $_val = "color";
                break;
            case 'left':
                $_val = "left";
                break;
            case 'center':
                $_val = "center";
                break;
            case 'right':
                $_val = "right";
                break;
            case 'list':
                $_val = 'list';
                break;
        }

        if (is_array($_arguments)) {
            $_arguments = implode(" ", $_arguments);

            if (!empty($_arguments)) {
                $_arguments = " " . $_arguments;
            }
        }
        if ($_property !== "") {
            return $_val !== null ? "[" . $_closed . $_val . $_property . $_arguments . "]" : null;
        }
        return $_val !== null ? "[" . $_closed . $_val . $_arguments . "]" : null;
    }

    protected function tagEncodeClosed(
    $_tag, $_arguments = null, $_property = ""
    ) {
        return $this->tagEncode($_tag, $_arguments, "/", $_property);
    }

    public function toHTML($str, $escapeHTML = true, $nr2br = true) {
        if (!$str) {
            return "";
        }

        if ($escapeHTML) {
            $str = htmlspecialchars($str, ENT_NOQUOTES);
        }

        foreach ($this->bbcode_table as $key => $val) {
            $str = preg_replace_callback($key, $val, $str);
        }

        if ($nr2br) {
            $str = preg_replace_callback("/\n\r?/", function ($match) {
                return "<br/>";
            }, $str);
        }

        return $str;
    }

}

?>
