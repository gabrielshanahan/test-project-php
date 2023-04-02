<h1>PHP Test Application</h1>
<div class="table-responsive" aria-label="Existing users">
    <table id="user-table" class="table table-striped">
        <thead class="table-dark">
        <tr aria-label="Table header">
            <th class="ps-3" scope="col">Name</th>
            <th class="ps-3" scope="col">E-mail</th>
            <th class="ps-3" scope="col">City</th>
        </tr>
        </thead>
        <tbody>
        <?foreach($users as $user){?>
            <tr aria-label="A record for user <?=$user->getName()?>">
                <td class="ps-3 overflow-auto" aria-label="Name"><?=$user->getName()?></td>
                <td class="ps-3 overflow-auto" aria-label="E-mail"><?=$user->getEmail()?></td>
                <td class="ps-3 overflow-auto" aria-label="City"><?=$user->getCity()?></td>
            </tr>
        <?}?>
        </tbody>
    </table>
</div>

<div class="row mt-3 mb-5 justify-content-end">
    <label for="city-filter" class="col-sm-2 col-form-label">Filter by city:</label>
    <div class="col-sm-2">
        <select id="city-filter" class="form-select" aria-label="Filter by city">
            <option value="" selected>No filter</option>
        </select>
    </div>
</div>

<div id="unknown-errors" class="hidden" aria-label="Unknown errors">
    <div class="alert alert-danger show" role="alert">
        <h4 class="alert-heading">An unknown error occurred!</h4>
        A technical description of the error can be found bellow.
        <hr>
        <p id="unknown-error-description" class="mb-0" aria-label="Technical description of error"></p>
    </div>
</div>

<form id="add-user" method="post" action="create.php" aria-label="Add a new user" novalidate>
    <div class="input-group mb-3 mt-4" aria-label="Input user data here">
        <div class="col-md me-3">
            <div class="input-group mb-3" aria-label="Name field">
                <label for="name" class="input-group-text fixed-form-label">Name</label>
                <input name="name" class="form-control" type="text" id="name" aria-describedby="name-error" required minlength="1" maxlength="65535"/>
                <span id="name-error" class="invalid-feedback" aria-live="polite"></span>
            </div>
        </div>
        <div class="col-md me-3">
            <div class="input-group mb-3" aria-label="E-mail field">
                <label for="email" class="input-group-text fixed-form-label">E-mail</label>
                <!-- Kudos 2 https://stackoverflow.com/a/201378-->
                <input name="email" class="form-control lowercase" type="email" id="email" aria-describedby="email-error" required maxlength="65535" pattern="(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|\x22(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*\x22)@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9]))\.){3}(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9])|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])"/>
                <span id="email-error" class="invalid-feedback" aria-live="polite"></span>
            </div>
        </div>
        <div class="col-md">
            <div class="input-group mb-3" aria-label="City field">
                <label for="city" class="input-group-text fixed-form-label">City</label>
                <input name="city" class="form-control" type="text" id="city" aria-describedby="city-error" required maxlength="65535"/>
                <span id="city-error" class="invalid-feedback" aria-live="polite"></span>
            </div>
        </div>
    </div>
    <button class="btn btn-primary float-end" type="submit">Create new row</button>
</form>

