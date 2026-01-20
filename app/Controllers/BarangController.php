<?php
require_once '../app/Models/Barang.php';
require_once '../app/Libraries/PDF.php';

class BarangController
{

    // Middleware Cek Admin
    private function checkAdmin()
    {
        if ($_SESSION['role'] !== 'admin') {
            echo "<script>alert('Akses Ditolak!'); window.location='index.php?page=barang';</script>";
            exit;
        }
    }

    public function index()
    {
        $model = new Barang();
        $data = [
            'barang' => $model->getAll(),
            'title' => 'Data Inventaris'
        ];
        $this->view('barang/index', $data);
    }

    public function create()
    {
        $this->checkAdmin();
        $model = new Barang();
        $data = [
            'title' => 'Tambah Barang',
            'kategori' => $model->getKategori(),
            'action' => 'index.php?page=barang&act=store'
        ];
        $this->view('barang/form', $data);
    }

    public function store()
    {
        $this->checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $model = new Barang();
            $data = [
                'nama' => $_POST['nama_barang'],
                'kategori' => $_POST['kategori_id'],
                'jumlah' => $_POST['jumlah'],
                'kondisi' => $_POST['kondisi'],
                'ket' => $_POST['keterangan']
            ];
            if ($model->insert($data)) {
                $_SESSION['success'] = "Data berhasil disimpan";
                header('Location: index.php?page=barang');
            }
        }
    }

    public function edit($id)
    {
        $this->checkAdmin();
        $model = new Barang();
        $data = [
            'title' => 'Edit Barang',
            'barang' => $model->getById($id),
            'kategori' => $model->getKategori(),
            'action' => 'index.php?page=barang&act=update'
        ];
        $this->view('barang/form', $data);
    }

    public function update()
    {
        $this->checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $model = new Barang();
            $data = [
                'nama' => $_POST['nama_barang'],
                'kategori' => $_POST['kategori_id'],
                'jumlah' => $_POST['jumlah'],
                'kondisi' => $_POST['kondisi'],
                'ket' => $_POST['keterangan']
            ];
            if ($model->update($id, $data)) {
                $_SESSION['success'] = "Data berhasil diperbarui";
                header('Location: index.php?page=barang');
            }
        }
    }

    public function delete($id)
    {
        $this->checkAdmin();
        $model = new Barang();
        if ($model->delete($id)) {
            $_SESSION['success'] = "Data berhasil dihapus";
        }
        header('Location: index.php?page=barang');
    }

    // --- EXPORT PDF ---
    public function export()
    {
        $this->checkAdmin();
        $model = new Barang();
        $barang = $model->getAll();

        $pdf = new PDF('P', 'mm', 'A4');
        $pdf->AddPage();

        // Kop Surat
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'LAPORAN INVENTARIS BARANG', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 6, 'Inventaris App', 0, 1, 'C');
        $pdf->Ln(8);

        // Header Tabel
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetFillColor(230, 230, 230);

        $pdf->Cell(10, 10, 'No', 1, 0, 'C', true);
        $pdf->Cell(50, 10, 'Nama Barang', 1, 0, 'L', true);
        $pdf->Cell(45, 10, 'Kategori', 1, 0, 'L', true);
        $pdf->Cell(15, 10, 'Jml', 1, 0, 'C', true);
        $pdf->Cell(27, 10, 'Kondisi', 1, 0, 'C', true);
        $pdf->Cell(50, 10, 'Keterangan', 1, 1, 'L', true);

        // Isi Data
        $pdf->SetFont('Arial', '', 10);
        $no = 1;

        foreach ($barang as $row) {
            $pdf->Row(
                [
                    $no++,
                    $row['nama_barang'],
                    $row['nama_kategori'],
                    $row['jumlah'],
                    $row['kondisi'],
                    $row['keterangan']
                ],
                [10, 50, 45, 15, 27, 50],
                ['C', 'L', 'L', 'C', 'C', 'L']
            );
        }

        $pdf->Output('I', 'Laporan-Inventaris.pdf');
    }


    private function view($viewName, $data = [])
    {
        extract($data);
        require_once '../views/layouts/header.php';
        require_once "../views/$viewName.php";
        require_once '../views/layouts/footer.php';
    }
}
