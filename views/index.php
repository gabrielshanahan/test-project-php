<h1>PHP Test Application</h1>
<div class="table-responsive" aria-label="Existing users">
    <table class="table table-striped">
        <thead class="table-dark">
        <tr>
            <th class="ps-3" scope="col">Name</th>
            <th class="ps-3" scope="col">E-mail</th>
            <th class="ps-3" scope="col">City</th>
        </tr>
        </thead>
        <tbody>
        <?foreach($users as $user){?>
            <tr aria-label="A user record">
                <td class="ps-3 overflow-auto" aria-label="Name"><?=$user->getName()?></td>
                <td class="ps-3 overflow-auto" aria-label="E-mail"><?=$user->getEmail()?></td>
                <td class="ps-3 overflow-auto" aria-label="City"><?=$user->getCity()?></td>
            </tr>
        <?}?>
        </tbody>
    </table>
</div>

<form id="add-user" method="post" action="create.php" aria-label="Add a new user">
    <div class="input-group mb-3 mt-4">
        <div class="col-md me-3">
            <div class="input-group mb-3" aria-label="Name field">
                <label for="name" class="input-group-text fixed-form-label">Name</label>
                <input name="name" class="form-control" type="text" id="name"/>
            </div>
        </div>
        <div class="col-md me-3">
            <div class="input-group mb-3" aria-label="E-mail field">
                <label for="email" class="input-group-text fixed-form-label">E-mail</label>
                <input name="email" class="form-control" type="email" id="email"/>
            </div>
        </div>
        <div class="col-md">
            <div class="input-group mb-3" aria-label="City field">
                <label for="city" class="input-group-text fixed-form-label">City</label>
                <input name="city" class="form-control" type="text" id="city"/>
            </div>
        </div>
    </div>
    <button class="btn btn-primary float-end" type="submit">Create new row</button>
</form>

