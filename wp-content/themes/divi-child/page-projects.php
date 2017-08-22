<?php
/*page template of projects on behalf of visitors*/
 get_header(); ?>

<div id="main" class="main">
<div class="container">
<section id="content" class="rs_content">
<?php
//get country of project
function getCountry($countryId)
{
    $countryObject = new Country();
    $result = $countryObject->selectCountryById($countryId);
    echo $result[0]['Country'];
}

$projectObject = new Project();
$projectsList = $projectObject->selectAll();
   
?>

  
        <div class="menuandwelcome">
       
        </div>
            <div id="redbar" class="alert-info">
                <strong>&nbsp;Projects: <?php echo count($projectsList)?> rows</strong>
                <button id="closeinfo" type="button" class="close">&times;</button>    
            </div>
            <div class="row-fluid">
                <label id="filtering">
                Search:&nbsp;<input type="text" id="filter">
                </label>
            </div>
            <br />
           
            <table id="projectsTable">
                    <thead>
                        <tr>
                        <th class="sorteer alfabet rs_projectcountry">COUNTRY</th>
                        <th class="sorteer alfabet rs_projecttitle">PROJECT TITLE</th>
                        <th class="sorteer alfabet rs_projectobjective">OBJECTIVE</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                    <?php
                    foreach ($projectsList as $project)
                    {
                        $i=$project['ProjectId'];
                    ?>
                    <tr>
                        <td id="<?php echo "projectCountry".$i ?>"><?php getCountry($project['CountryId']); ?></td> 
                        <td id="<?php echo "projectTitle".$i ?>"><?php echo $project['ProjectTitle'] ?></td>
                        <td id="<?php echo "objective".$i ?>"><?php echo $project['Objective']; ?></td>
                        
                    </tr>
                    <?php
                    }
                    ?>
                    </tbody>
             </table>
              
</section>
    
<div class="clear"></div>
</div>
</div>

<?php get_footer(); ?>



