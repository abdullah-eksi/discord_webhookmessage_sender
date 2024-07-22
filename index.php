<?php
session_start();
ob_start();

$process = [
    "status" => "",
    "true" => ""
];


$webhooks = isset($_SESSION['webhook']) ? unserialize($_SESSION['webhook']) : array();


if(isset($_POST['webhook_ekle'])) {
    $webhook_ad = $_POST['webhook_adi'];
    $webhook_url = $_POST['webhook_url'];
    $webhook_id = rand(0,10000);

    $webhook_data = array($webhook_ad, $webhook_url, $webhook_id);

    $webhooks[] = $webhook_data;
    $_SESSION["webhook"] = serialize($webhooks);
    $process["true"] = "true";
    $process["status"] = "webhook başarıyla eklendi";
}


if(isset($_POST['mesaj_gonder'])) {
    $selected_webhook_id = $_POST['webhook_id'];


    $selected_webhook = null;
    foreach($webhooks as $key => $webhook) {
        if($webhook[2] == $selected_webhook_id) {
            $selected_webhook = $webhook;
            unset($webhooks[$key]);
            break;
        }
    }

    if($selected_webhook) {
        $webhook_url = $selected_webhook[1];
        $message = $_POST['mesaj'];


        $data = array('content' => $message);


        $ch = curl_init($webhook_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);


        if ($http_status == 204) {
            $process["true"] = "true";
            $process["status"] = "Mesaj Gönderme İşlemi Başarılı";
        } else {
            $process["true"] = "false";
            $process["status"] = "Mesaj Gönderme İşlemi Başarısız";
        }
    }
}



if(isset($_POST['webhook_sil'])) {
    $selected_webhook_id = $_POST['webhook_id'];


    $selected_webhook = null;
    foreach($webhooks as $key => $webhook) {
        if($webhook[2] == $selected_webhook_id) {
            $selected_webhook = $webhook;
            unset($webhooks[$key]);
            break;
        }
    }

    if($selected_webhook) {
        $_SESSION["webhook"] = serialize($webhooks);
        $process["true"] = "true";
        $process["status"] = "Webhook başarıyla silindi";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discord Webhook Mesaj Gönder</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #121212;
            color: #fff;
        }
        .container {
            margin-top: 50px;
        }
        .card {
            background-color: #212121;
            border-color: #343a40;
            color: #fff;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <!-- Webhook Ekleme Formu -->
        <div class="col-md-6">
            <div class="card">
                <div  class="card-body">
                    <h5 class="card-title">Webhook Ekle</h5>
                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="webhook_url">Webhook Adı</label>
                            <input type="text" class="form-control" id="webhook_url" name="webhook_adi" required>
                        </div>
                        <div class="form-group ">
                            <label for="webhook_url">Webhook URL</label>
                            <input type="text" class="form-control " id="webhook_url" name="webhook_url" required>
                        </div>
                        <div class="mb-5">

                        </div>
                        <div class="mb-5">

                        </div>
                        <button name="webhook_ekle" type="submit" class="btn btn-primary w-100">Ekle</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Webhook Mesaj Gönderme Formu -->
        <div class="col-md-6">
           <div class="card">
               <div class="card-body">
                   <h5 class="card-title">Webhook'a Mesaj Gönder</h5>
                   <form id="mesaj_gonder_form" action="" method="POST">
                       <div class="form-group">
                           <label for="webhook_id">Webhook Seç</label>
                           <select class="form-control" id="webhook_id" name="webhook_id" required>
                               <?php foreach($webhooks as $webhook): ?>
                                   <option value="<?php echo $webhook[2]; ?>"><?php echo $webhook[0]; ?></option>
                               <?php endforeach; ?>
                           </select>
                       </div>
                       <div class="form-group">
                           <label for="mesaj">Mesaj</label>
                           <textarea class="form-control" id="mesaj" name="mesaj" rows="3" required></textarea>
                       </div>
                       <button name="mesaj_gonder" type="submit" class="btn btn-primary w-100">Gönder</button>
                   </form>
                   <br>
                   <!-- Webhook Sil Butonu -->
                   <form id="webhook_sil_form" action="" method="POST">
                       <input type="hidden" id="webhook_id_sil" name="webhook_id">
                       <button name="webhook_sil" type="submit" class="btn btn-danger w-100" onclick="return confirm('Bu webhooku silmek istediğinize emin misiniz?')">Sil</button>
                   </form>
               </div>
           </div>
       </div>
   </div>
</div>
    </div>
</div>

<?php if (!empty($process["true"])): ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php if ($process["true"] == "true"): ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $process["status"]; ?>
                    </div>
                <?php else: ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $process["status"]; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>

    document.querySelectorAll('.btn-danger').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('webhook_id_sil').value = document.getElementById('webhook_id').value;
        });
    });
</script>
</body>
</html>
