<h1>PHP Test Application</h1>
<hr>
<div class="row pt-4 pb-4">
    <h2>Add a new user</h2>
    <div id="unknown-errors" class="hidden" aria-label="Unknown errors">
        <div class="alert alert-danger show" role="alert">
            <h4 class="alert-heading">An unknown error occurred!</h4>
            A technical description of the error can be found bellow.
            <hr>
            <p id="unknown-error-description" class="mb-0" aria-label="Technical description of error"></p>
        </div>
    </div>
    <form id="add-user" method="post" action="create.php" aria-label="Add a new user" novalidate>
        <div class="input-group pt-4 pb-4" aria-label="Input user data here">
            <div class="col-lg pb-3 pe-3">
                <div class="input-group has-validation" aria-label="Name field">
                    <label for="name" class="input-group-text fixed-form-label">Name</label>
                    <input name="name" class="form-control" type="text" id="name" aria-describedby="name-error" required minlength="1" maxlength="65535" pattern="^(?![0-9]).*"/>
                    <span id="name-error" class="invalid-feedback" aria-live="polite"></span>
                </div>
            </div>
            <div class="col-lg pb-3 pe-3">
                <div class="input-group has-validation" aria-label="E-mail field">
                    <label for="email" class="input-group-text fixed-form-label">E-mail</label>
                    <!-- Kudos 2 https://stackoverflow.com/a/201378 -->
                    <input name="email" class="form-control lowercase" type="email" id="email" aria-describedby="email-error" required maxlength="65535" pattern="(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|\x22(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*\x22)@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9]))\.){3}(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9])|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])"/>
                    <span id="email-error" class="invalid-feedback" aria-live="polite"></span>
                </div>
            </div>

            <div class="col-lg pb-3 pe-3">
                <div class="input-group has-validation" aria-label="City field">
                    <label for="city" class="input-group-text fixed-form-label">City</label>
                    <!-- Kudos 2 https://stackoverflow.com/a/25677072 -->
                    <input name="city" class="form-control" type="text" id="city" aria-describedby="city-error" required maxlength="65535" pattern="^([a-zA-Z\u0080-\u024F]+(?:. |-| |'))*[a-zA-Z\u0080-\u024F]*$"/>
                    <span id="city-error" class="invalid-feedback" aria-live="polite"></span>
                </div>
            </div>

            <div class="col-lg pb-3 rightmost-responsive">
                <div class="input-group has-validation" aria-label="Phone field">
                    <label for="phone" class="input-group-text fixed-form-label">Phone</label>
                    <!-- Kudos 2 https://uibakery.io/regex-library/phone-number -->
                    <input name="phone" class="form-control" type="text" id="phone" aria-describedby="phone-error" required minlength="7" maxlength="14" pattern="\+?[1-9][0-9]{7,14}"/>
                    <span id="phone-error" class="invalid-feedback" aria-live="polite"></span>
                </div>
            </div>
        </div>
        <input type="hidden" name="csrf-token" id="csrf-token" aria-hidden="true" value="<?=$_SESSION['csrf_token']?>">
        <button class="btn btn-primary float-lg-end" type="submit">Create new row</button>
    </form>
</div>
<hr>
<div class="row pt-4 pb-4">
    <div class="col-sm-8">
        <h2>Existing users</h2>
    </div>
    <div class="col">
        <select id="city-filter" class="form-select" aria-label="Filter by city">
            <option value="" selected>Filter by city</option>
        </select>
    </div>
</div>
<div class="table-responsive rounded" aria-label="Existing users">
    <table id="user-table" class="table table-striped table-bordered">
        <thead class="table-dark">
        <tr aria-label="Table header">
            <th class="ps-3" scope="col">Name</th>
            <th class="ps-3" scope="col">E-mail</th>
            <th class="ps-3" scope="col">City</th>
            <th class="ps-3" scope="col">Phone</th>
        </tr>
        </thead>
        <tbody>
        <?foreach($users as $user){?>
            <tr aria-label="A record for user <?=$user->getName()?>">
                <td class="ps-3 overflow-auto" aria-label="Name"><?=$user->getName()?></td>
                <td class="ps-3 overflow-auto" aria-label="E-mail"><?=$user->getEmail()?></td>
                <td class="ps-3 overflow-auto" aria-label="City"><?=$user->getCity()?></td>
                <td class="ps-3 overflow-auto" aria-label="Phone"><?=$user->getPhone()?></td>
            </tr>
        <?}?>
        </tbody>
    </table>
</div>

