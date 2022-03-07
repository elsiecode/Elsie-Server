<?php

function elsie_tag($e_txt_file,$e_tag) {
    $e_open_tag = "<".$e_tag.">";
    $e_close_tag = "</".$e_tag.">";
    $e_start_tag = strpos($e_txt_file,$e_open_tag) + strlen($e_open_tag);
    $e_remove_before_tag = substr($e_txt_file,$e_start_tag);
    $e_tag_content = strstr($e_remove_before_tag, $e_close_tag, true);
    return $e_tag_content;
}

function elsie_find_tag($e_txt_file,$e_tag) {
    $e_open_tag = "<".$e_tag.">";
    $e_close_tag = "</".$e_tag.">";
    
    if(strpos($e_txt_file,$e_open_tag) !== false){
        $e_open_found ="found";
    } else{
        $e_open_found ="not found";
    }

    if(strpos($e_txt_file,$e_close_tag) !== false){
        $e_close_found ="found";
    } else{
        $e_close_found ="not found";
    }

    if($e_open_found =="found" and $e_close_found =="found") {
        $e_found ="found";
    } else{
        $e_found ="not found";
    }

    return $e_found;
}

function elsie_remove_folder($e_folder){
    if(is_dir($e_folder) === true){
        
        $e_folder_files= scandir($e_folder);
        unset($e_folder_files[0],$e_folder_files[1]);
        
        foreach($e_folder_files as $e_F => $e_F_Name){
            $e_currentPath = $e_folder.'/'.$e_F_Name;
            $e_filetype = filetype($e_currentPath);
            if($e_filetype == 'dir'){
                elsie_remove_folder($e_currentPath);
            }else{
                unlink($e_currentPath);
            }
            unset($e_folder_files[$F]);
        }
        rmdir($e_folder);
    }
    
}
function elsie_txt_to_html($e_txt_file) {
    $e_txt_file_content = file_get_contents($e_txt_file, true);
    $e_txt_file_title_tag = str_replace("<title>", "<h1>", $e_txt_file_content);
    $e_txt_file_title_close_tag = str_replace("</title>", "</h1>", $e_txt_file_title_tag);
    $e_txt_file_heading_open_tag = str_replace("<heading>", "<h2>", $e_txt_file_title_close_tag);
    $e_txt_file_heading_close_tag = str_replace("</heading>", "</h2>", $e_txt_file_heading_open_tag);
    $e_txt_file_paragraph_tag = str_replace("<paragraph>", "<p>", $e_txt_file_heading_close_tag);
    $e_txt_file_paragraph_close_tag = str_replace("</paragraph>", "</p>", $e_txt_file_paragraph_tag);
    $e_txt_file_link_front = str_replace("<link><url>", "<a href=\"", $e_txt_file_paragraph_close_tag);
    $e_txt_file_link_middle = str_replace("</url><text>", "\"target=\"_blank\">", $e_txt_file_link_front);
    $e_txt_file_link_back = str_replace("</text></link>", "</a>", $e_txt_file_link_middle);

    $e_html_code = $e_txt_file_link_back;

    return $e_html_code;
}

function elsie_code_website() {
    # Text File Contents
    $e_site_info_txt_path = 'User/site-info.txt';
    $e_style_txt_path = 'User/style.txt';
    $e_coming_soon_txt_path = 'User/coming-soon.txt';
    $e_blog_post_txt_path = 'User/blog-post.txt';

    # Site Info File
    if (file_exists($e_site_info_txt_path)) {
        
        $e_site_info_txt_file = file_get_contents($e_site_info_txt_path, true);
        
        $e_find_site_title_tag = elsie_find_tag($e_site_info_txt_file,'title');
        $e_find_site_description_tag = elsie_find_tag($e_site_info_txt_file,'description');

        if ($e_find_site_title_tag =='found') {
            $e_website_title = elsie_tag($e_site_info_txt_file,'title');
        }else{
            $e_website_title ='none';
        }

        if ($e_find_site_description_tag =='found') {
            $e_website_description = elsie_tag($e_site_info_txt_file,'description');
        }else{
            $e_website_description ='none';
        }

    } else { 
        $e_website_title ='none';
        $e_website_description ='none';
    }

    # Site Style File
    if (file_exists($e_style_txt_path)) {
        $e_style_txt_file = file_get_contents($e_style_txt_path, true);
        $e_find_site_theme_tag = elsie_find_tag($e_style_txt_file,'theme');

        if ($e_find_site_theme_tag =='found') {
            $e_website_theme = elsie_tag($e_style_txt_file,'theme');
        }else{
            $e_website_theme ='none';
        }

    } else {
        $e_website_theme ='none';
    }


    # Convert Blog Post File To Html
    if (file_exists($e_blog_post_txt_path)) {
        $e_blog_post_code = elsie_txt_to_html($e_blog_post_txt_path);
    }


    # Create Homepage
    $e_homepage_file = fopen("../index.html", "w") or die("Unable to open file!");
    fwrite($e_homepage_file, "<html>\n");
    fwrite($e_homepage_file, "<head>\n");
    if ($e_website_title !== 'none') {
        fwrite($e_homepage_file, "<title>".$e_website_title."</title>\n");
    }
    fwrite($e_homepage_file, "<meta charset=\"UTF-8\">\n");
    if ($e_website_description !== 'none') {
        fwrite($e_homepage_file, "<meta name=\"description\" content=\"".$e_website_description."\">\n");
    }
    fwrite($e_homepage_file, "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\n");
    fwrite($e_homepage_file, "<style>\n");
    fwrite($e_homepage_file, "body{\n");
    if ($e_website_theme =='easter egg') {
        fwrite($e_homepage_file, "background-color:#b5e3af;\n");
    }elseif ($e_website_theme =='nightsky') {
        fwrite($e_homepage_file, "background-color:#0f2531;\n");
    }elseif ($e_website_theme =='grasshopper') {
            fwrite($e_homepage_file, "background-color:#4d7b26;\n");
    }elseif ($e_website_theme =='lights out') {
            fwrite($e_homepage_file, "background-color:#000;\n");
    }else{
        fwrite($e_homepage_file, "background-color:#fff;\n");
    }
    if ($e_website_theme =='easter egg') {
        fwrite($e_homepage_file, "color:#d5d6ea;\n");
    }elseif ($e_website_theme =='nightsky') {
        fwrite($e_homepage_file, "color:#cce5ff;\n");
    }elseif ($e_website_theme =='grasshopper') {
        fwrite($e_homepage_file, "color:#fff;\n");
    }elseif ($e_website_theme =='lights out') {
        fwrite($e_homepage_file, "color:#fff;\n");
    }else{
        fwrite($e_homepage_file, "color:#000;\n");
    }
    fwrite($e_homepage_file, "font-family: Arial, Helvetica, sans-serif;\n");
    fwrite($e_homepage_file, "padding:10px;\n");
    fwrite($e_homepage_file, "}\n");
    fwrite($e_homepage_file, "h1{\n");
    fwrite($e_homepage_file, "font-size:30px;\n");
    fwrite($e_homepage_file, "text-align:center;\n");
    fwrite($e_homepage_file, "}\n");
    fwrite($e_homepage_file, "a:link {\n");
        if ($e_website_theme =='easter') {
            fwrite($e_homepage_file, "color:#fff;\n");
        }elseif ($e_website_theme =='nightsky') {
            fwrite($e_homepage_file, "color:#cce5ff;\n");
        }elseif ($e_website_theme =='grasshopper') {
            fwrite($e_homepage_file, "color:#fff;\n");
        }elseif ($e_website_theme =='lights out') {
            fwrite($e_homepage_file, "color:#fff;\n");
        }else{
            fwrite($e_homepage_file, "color:#000;\n");
        }
        fwrite($e_homepage_file, "}\n");
        fwrite($e_homepage_file, "a:visited {\n");
        if ($e_website_theme =='easter') {
            fwrite($e_homepage_file, "color:#fff;\n");
        }elseif ($e_website_theme =='nightsky') {
            fwrite($e_homepage_file, "color:#cce5ff;\n");
        }elseif ($e_website_theme =='grasshopper') {
            fwrite($e_homepage_file, "color:#fff;\n");
        }elseif ($e_website_theme =='lights out') {
            fwrite($e_homepage_file, "color:#fff;\n");
        }else{
            fwrite($e_homepage_file, "color:#000;\n");
        }
        fwrite($e_homepage_file, "}\n");
        fwrite($e_homepage_file, "a:hover {\n");
        if ($e_website_theme =='easter') {
            fwrite($e_homepage_file, "color:#fff;\n");
        }elseif ($e_website_theme =='nightsky') {
            fwrite($e_homepage_file, "color:#cce5ff;\n");
        }elseif ($e_website_theme =='grasshopper') {
            fwrite($e_homepage_file, "color:#fff;\n");
        }elseif ($e_website_theme =='lights out') {
            fwrite($e_homepage_file, "color:#fff;\n");
        }else{
            fwrite($e_homepage_file, "color:#000;\n");
        }
        fwrite($e_homepage_file, "}\n");
        fwrite($e_homepage_file, "a:active {\n");
        if ($e_website_theme =='easter') {
            fwrite($e_homepage_file, "color:#fff;\n");
        }elseif ($e_website_theme =='nightsky') {
            fwrite($e_homepage_file, "color:#cce5ff;\n");
        }elseif ($e_website_theme =='grasshopper') {
            fwrite($e_homepage_file, "color:#fff;\n");
        }elseif ($e_website_theme =='lights out') {
            fwrite($e_homepage_file, "color:#fff;\n");
        }else{
            fwrite($e_homepage_file, "color:#000;\n");
        }
        fwrite($e_homepage_file, "}\n");
    fwrite($e_homepage_file, "</style>\n");
    fwrite($e_homepage_file, "</head>\n");
    fwrite($e_homepage_file, "<body>\n");
    if (file_exists($e_blog_post_txt_path)) {
        fwrite($e_homepage_file, $e_blog_post_code."\n");
    }elseif($e_website_title !=='none'){
        fwrite($e_homepage_file, "<h1>".$e_website_title."</h1>\n");
    }else{
        fwrite($e_homepage_file, "<h1>Website Coming Soon</h1>\n");  
    }
    fwrite($e_homepage_file, "</body>\n");
    fwrite($e_homepage_file, "</html>\n");
    fclose($e_homepage_file);

    # Go To Website
    header("Location: ../index.html");
    # Remove Elsie From Server
    elsie_remove_folder("../elsie");

}
?>