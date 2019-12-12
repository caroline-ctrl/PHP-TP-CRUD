<?php
include 'function.php';
$pdo = pdo_connect_mysql();
//Pour obtenir la page
$page = isset($_GET['page']) AND is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
//Nombre de contact par page
$records_per_page = 5;
//Requete
$stmt = $pdo->prepare('SELECT * FROM contacts ORDER BY id LIMIT :current_page, :records_per_page');
//Obtenir les contacts de notre table et prepare le SQL Statement
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':records_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
//Affiche les contacts dans notre template
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
$num_contacts = $pdo->query('SELECT COUNT(*) FROM contacts')->fetchColumn();

?>  

<?=template_header('read')?>
<div class="content read">
<h2>Read Contacts</h2>
<a href="create.php" class="create contact">Create Contact</a>
<table>
<thead>
    <tr>
        <td>#</td>
        <td>Name</td>
        <td>Email</td>
        <td>Phone</td>
        <td>Title</td>
        <td>Created</td>
    </tr>
</thead>
<tbody>
    <?php foreach($contacts as $contact):?>
        <tr>
            <td><?=$contact['id']?></td>
            <td><?=$contact['name']?></td>
            <td><?=$contact['email']?></td>
            <td><?=$contact['phone']?></td>
            <td><?=$contact['title']?></td>
            <td><?=$contact['created']?></td>
        </tr>
    <?php endforeach;?>
</tbody>
</table>
</div>