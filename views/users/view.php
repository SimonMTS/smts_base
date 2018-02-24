<div class="row">
	<div class="col-md-12">
		<nav class="mt-4" aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?=Smts::$config['BaseUrl'] ?>">Home</a></li>
				<li class="breadcrumb-item"><a href="<?=Smts::$config['BaseUrl'] ?>users">Users</a></li>
				<li class="breadcrumb-item active">View</li>
			</ol>
		</nav>
	</div>
</div>

<div class="row">
	<div class="col-md-4">
		<div class="card mb-4">
			<img class="card-img-top" src="<?=Smts::$config['BaseUrl'].$user->pic ?>">
			<div class="card-body">
				<a href="<?= Smts::$config['BaseUrl'] ?>users/edit/<?=$user->id ?>" class="btn btn-primary float-right">edit</a>
				<h3 class="card-title"><?=$user->name ?></h3>
				<?=User::Role($user->role) ?>
				<hr>
				<dl class="dl-horizontal">
					<dt>First name</dt>
					<dd><?=$user->voornaam ?></dd>
					<dt>Last name</dt>
					<dd><?=$user->achternaam ?></dd>
					<dt>Gender</dt>
					<dd><?=($user->geslacht == 'm') ? 'Male' : 'Female' ?></dd>
					<dt>Age</dt>
					<dd><?php
						$datetime1 = new DateTime();
						$datetime2 = DateTime::createFromFormat('d/m/Y:H:i:s', $user->geboorte_datum);
						$interval = $datetime1->diff($datetime2);
						echo $interval->format('%y');
					?> y/o</dd>
					<!-- <dt>Address</dt>
					<dd>
						<?=explode(',', $user->adres)[0] ?>
						<?=explode(',', $user->adres)[1] ?>, <br>
						<?=explode(',', $user->adres)[2] ?>, 
						<?=explode(',', $user->adres)[3] ?>, 
						<?=explode(',', $user->adres)[4] ?>
					</dd> -->
					<dd>
					<address>
						<strong>Address</strong><br>
						<?=explode(',', $user->adres)[0] ?> <?=explode(',', $user->adres)[1] ?><br>
						<?=explode(',', $user->adres)[2] ?>, 
						<?=explode(',', $user->adres)[3] ?><br>
						<?=explode(',', $user->adres)[4] ?>
					</address>
					</dd>
					<dt>Registration date</dt>
					<dd>~20/05/2017</dd>
				</dl>
			</div>
		</div>
	</div>
</div>