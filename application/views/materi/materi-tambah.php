<?php
$uuid = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

?>
<div class="container-fluid">
    <?php if ($this->session->flashdata('error_msg')) : ?>
        <div class="alert alert-danger">
            <?= $this->session->flashdata('error_msg'); ?>
        </div>
    <?php endif; ?>


    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Tambah Data Materi</h1>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url('materi') ?>">
                    <i class="fas fa-arrow-left">
                    </i> Daftar Materi</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Tambah</li>
        </ol>
    </nav>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form class="user" method="post" enctype="multipart/form-data"
                action="<?= base_url('materi/tambah/' . $uuid); ?>">
                <input type="hidden" name="namaMapel" value="<?= $uuid; ?>">
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label class="form-label font-weight-bold">Thumbnail</label>
                        <input type="file" name="thumbnail" id="thumbnail" class="form-control"
                            placeholder="Masukkan Thumbnail" value="<?= set_value('thumbnail'); ?>">
                        <small>format file : JPG, JPEG, PNG. Maximal 2Mb</small>
                        <div class="invalid-feedback <?= !empty(form_error('thumbnail')) ? 'd-block' : ''; ?> ">
                            <?= form_error('thumbnail') ?>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label class="form-label font-weight-bold">Judul <span class="text-danger">*</span></label>
                        <input type="text" name="judul" id="judul" class="form-control"
                            placeholder="Masukkan Judul Materi" value="<?= set_value('judul'); ?>">
                        <div class="invalid-feedback <?= !empty(form_error('judul')) ? 'd-block' : ''; ?> ">
                            <?= form_error('judul') ?>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label class="form-label font-weight-bold">Upload File Materi <span
                                class="text-danger">*</span></label>
                        <input type="file" name="berkas" id="berkas" class="form-control"
                            placeholder="Masukkan materi Materi" value="<?= set_value('berkas'); ?>">
                        <small>format file : PDF, DOCX, PPTX, Video. Maximal 50Mb</small>
                        <div class="invalid-feedback <?= !empty(form_error('berkas')) ? 'd-block' : ''; ?> ">
                            <?= form_error('berkas') ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <button type="submit" class="btn btn-md btn-success mr-2">
                            <i class="fa fa-save"></i> Simpan
                        </button>
                        <a href="<?= base_url('Materi') ?>" class="btn btn-md btn-danger">
                            <i class="fa fa-times"></i> Batal
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>