<?php
class UIInterface {
    public function table($head, $body, $data, $actions = null) {
        echo '<table class="table table-hover table-striped table-bordered">';
        echo '<thead><tr>';
        foreach ($head as $h) {
            echo "<th>$h</th>";
        }
        echo '</tr></thead>';
        echo '<tbody>';
        foreach ($data as $row) {
            echo '<tr data-bs-toggle="modal" data-bs-target="#' . $actions . '=' . $row['id'] . '">';
            foreach ($body as $key) {
                if ($key === 'status') {
                    echo '<td>' . ($row['status'] ? '✅อนุมัติแล้ว' : '🙈ยังไม่อนุมัติ') . '</td>';
                } elseif (strpos($key, ' ') !== false) {
                    $keys = explode(' ', $key); 
                    $value = '';
                    foreach ($keys as $k) {
                        $value .= $row[$k]. ' ';
                    }
                    echo '<td>' . trim($value) . '</td>';
                } else {
                    echo '<td>' . $row[$key] . '</td>';
                }
            }
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    }

    public function ntdotjsx($message, $type) {
        echo "
        <div class='toast-container position-fixed bottom-0 end-0 p-3'>
            <div id='liveToast' class='toast fade text-bg-$type'>
                <div class='toast-body'>
                    $message
                </div>
            </div>
        </div>
        ";
    }

    public function ConA($head, $message, $type, $req) {
        echo "
        <div class='modal fade' id='$req'>
            <div class='modal-dialog modal-dialog-centered p-4 py-md-5'>
                <div class='modal-content rounded-4 shadow'>
                    <div class='modal-header border-bottom-0'>
                        <h1 class='modal-title fs-5'>$head</h1>
                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                    </div>
                    <div class='modal-body py-0'>
                        <p>$message</p>
                    </div>
                    <div class='modal-footer flex-column align-items-stretch w-100 gap-2 pb-3 border-top-0'>
                        <a href='class/handle.php?$req' class='btn btn-lg btn-$type'>ยืนยัน</a>
                    </div>
                </div>
            </div>
        </div>
        ";
    }
}
?>
