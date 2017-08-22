<?php
//page template of project types
//require_once RS_PLUGIN_PATH.'appcode\webapp\view\projecttypes.php';
//session_start();

get_header();
 ?>

<div id="main" class="main">
<div class="container">
<section id="content" class="rs_content">
<?php
$pTObject = new ProjectType();
$pTypes = $pTObject -> selectAll();
?>
<div id="redbar" class="alert-info">
                <strong>&nbsp;Project types: <?php echo count($pTypes)?> rows</strong>
                <button id="closeinfo" type="button" class="close">&times;</button>    
</div>
<p><a href="http://localhost:8080/rootsandshootseurope/project-type-form/" class="buttonadd">&nbsp;Add project type</a></p><br />
<table id="projectTypesTable">
<thead>
<tr>
<th class="rs_projecttypeid">Number</th>
<th class="rs_projecttype">Project type</th>
<th class="rs_projecttypeinfo">Project type info</th>
<th class="rs_action">Action</th>
</tr>
</thead>
<tbody>
<?php
foreach($pTypes as $pType)
{
    $i = $pType['ProjectTypeId'];
?>
<tr>
<td><?php  echo $pType['ProjectTypeId']; ?></td>
<td><?php  echo $pType['ProjectType']; ?></td>
<td><?php  echo $pType['ProjectTypeInfo']; ?></td>
<td>
<button id="<?php echo "ptBtnDelete".$i?>" title="delete" class="btndelete">Delete</button>
<form method="post" action="http://localhost:8080/rootsandshootseurope/project-type-form/" class="rs_form_edit">
    <input name="projecttypeid" value="<?php echo $i; ?>" type="hidden" />
    <input type="submit" value="Edit" class="btnedit" title="edit" /> 
</form>
</td>
</tr>
<?php }//end foreach ?>
</tbody>
</table>
</section>
    
<div class="clear"></div>
</div>
</div>

<?php get_footer(); ?>

