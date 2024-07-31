<?php
/**
 * Template Name: Download Jobs
 */


function export_custom_post_type_xml() {
    $args = array(
        'post_type' => 'job-manager',
        'posts_per_page' => -1
    );
    $jobs_query = new WP_Query($args);
    
    if ($jobs_query->have_posts()) {
        $xml = new SimpleXMLElement('<jobs/>');
    
        while ($jobs_query->have_posts()) {
            $jobs_query->the_post();
            $job = $xml->addChild('job');
            
            $job->addChild('ID', htmlspecialchars(get_the_ID(), ENT_XML1, 'UTF-8'));
            $job->addChild('Title', htmlspecialchars(get_the_title(), ENT_XML1, 'UTF-8'));
            $job->addChild('Content', htmlspecialchars(get_the_content(), ENT_XML1, 'UTF-8'));
            $job->addChild('Permalink', htmlspecialchars(get_permalink(get_the_ID()), ENT_XML1, 'UTF-8'));

            $job_description = get_post_meta(get_the_ID(), 'job_description', true);
            $job_requirements = get_post_meta(get_the_ID(), 'job_requirements', true);
            $city_name = get_post_meta(get_the_ID(), 'city_name', true);

            if(!empty($city_name)){
                $job->addChild('City-Name', htmlspecialchars($city_name, ENT_XML1, 'UTF-8'));
            }
            if(!empty($job_description)){
                $job->addChild('Job-Description', htmlspecialchars($job_description, ENT_XML1, 'UTF-8'));
            }
            if(!empty($job_requirements)){
                $job->addChild('Job-Requirements', htmlspecialchars($job_requirements, ENT_XML1, 'UTF-8'));
            }
    
        }
    
        header('Content-Disposition: attachment; filename="jobs.xml"');
        header('Content-Type: text/xml');
        echo $xml->asXML();
        exit;
    }
}


if (isset($_POST['download_xml'])) {
    export_custom_post_type_xml();
    exit;
}

?>
<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <h1>Export Custom Post Type Data to XML</h1>
        <form method="post">
            <button type="submit" name="download_xml">Download XML</button>
        </form>
    </main>
</div>

