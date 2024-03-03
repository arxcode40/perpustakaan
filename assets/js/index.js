'use strict'

let application = 'perpustakaan'
application = application ? `/${application}` : application

$.fn.replaceClass = function(oldClass, newClass) {
  return this.removeClass(oldClass).addClass(newClass)
}

function detailAnggota(code) {
  $.ajax({
    dataType: 'json',
    success: function(data) {
      $('#detailModal').children('input[type=radio]').attr('checked', false)
      $('#detailId').val(code)
      $('#detailCode').val(code)
      $('#detailAmount').val(data.jumlah_pinjam)
      $('#detailUser').val(data.nama_pengguna)
      $('#detailPass').val(data.kata_sandi)
      $('[for=detailPrivileges]').nextAll().children(`input[value=${data.hak_akses}]`).attr('checked', true)
      $('#detailName').val(data.nama_lengkap)
      $('[for=detailGender]').nextAll().children(`input[value='${data.jenis_kelamin}']`).attr('checked', true)
      $('#detailPlace').val(data.tempat_lahir)
      $('#detailDate').val(data.tanggal_lahir)
      $('#detailAddress').text(data.alamat)
      $('#detailPhone').val(data.nomor_telepon)
      $('#detailStatus').val(data.status_anggota)
      $('#deleteAnggota').attr('href', `${location.origin}${application}/anggota/hapus/${code}`)
      if(data.status_anggota === 'Terdaftar') {
        $('#verifyAnggota').attr('href', `${location.origin}${application}/anggota/verifikasi/${code}`).show()
      } else {
        $('#verifyAnggota').attr('href', '').hide()
      }
    },
    url: `${location.origin}${application}/anggota/detail/${code}`
  })
}

function detailBuku(code) {
  $.ajax({
    dataType: 'json',
    success: function(data) {
      $('#detailModal').children('option').attr('selected', false)
      $('#detailId').val(code)
      $('#detailCode').val(code)
      $('#detailTitle').val(data.judul)
      $('#detailType').children(`option[value='${data.jenis_koleksi}']`).attr('selected', true)
      $('#detailAuthor').val(data.pengarang)
      $('#detailPublisher').val(data.penerbit)
      $('#detailYear').val(data.tahun_terbit)
      $('#detailPrint').val(data.cetakan)
      $('#detailEdition').val(data.edisi)
      $('#detailStatus').children(`option[value='${data.status_buku}']`).attr('selected', true)
      $('#deleteBuku').attr('href', `${location.origin}${application}/buku/hapus/${code}`)
    },
    url: `${location.origin}${application}/buku/detail/${code}`
  })
}

function detailPeminjaman(code) {
  $.ajax({
    dataType: 'json',
    success: function(data) {
      $('#detailModal').children('option').attr({
        'hidden': false,
        'selected': false
      })
      $('#detailId').val(code)
      $('#detailCode').val(code)
      $('#detailMember').children(`option[value=${data.kode_anggota}]`).attr('selected', true)
      $('#detailLoan').val(data.tanggal_pinjam)
      $('#detailReturn').val(data.tanggal_kembali)
      $('#detailBook').children().first().val(data.kode_buku).text(`${data.kode_buku} - ${data.judul}`)
      if($('#detailBook').children(`option[value=${data.kode_buku}]`).length > 1) {
        $('#detailBook').children().first().attr('hidden', true)
      }
      $('#detailBook').children(`option[value=${data.kode_buku}]`).attr('selected', true)
      $('#detailStatus').val(data.status_peminjaman)
      $('#deletePeminjaman').attr('href', `${location.origin}${application}/peminjaman/hapus/${code}`)
      if(data.status_peminjaman === 'Tertunda') {
        $('#verifyTransaksi').attr('href', `${location.origin}${application}/peminjaman/verifikasi/${code}`).show()
      } else {
        $('#verifyTransaksi').attr('href', '').hide()
      }
    },
    url: `${location.origin}${application}/peminjaman/detail/${code}`
  })
}

function detailPengembalian(code) {
  $.ajax({
    dataType: 'json',
    success: function(data) {
      console.log(data)
      $('#detailModal').children('option').attr('selected', false)
      $('#detailId').val(data.kode_transaksi)
      $('#detailCode').val(`${data.kode_transaksi} - ${data.nama_lengkap} - ${data.judul}`)
      $('#detailTransaction').val(data.tanggal_pengembalian)
      $('#detailPenalty').val(`Rp${Intl.NumberFormat('id-ID', {minimumFractionDigits: 2}).format(data.denda)}`)
      $('#detailInformation').children(`option[value=${data.keterangan}]`).attr('selected', true)
      $('#detailStatus').val(data.status_pengembalian)
      $('#deletePengembalian').attr('href', `${location.origin}${application}/pengembalian/hapus/${code}`)
      if(data.status_pengembalian === 'Tertunda') {
        $('#verifyTransaksi').attr('href', `${location.origin}${application}/pengembalian/verifikasi/${code}`).show()
      } else {
        $('#verifyTransaksi').attr('href', '').hide()
      }
    },
    url: `${location.origin}${application}/pengembalian/detail/${code}`
  })
}

function filterUsername() {
  $(event.target).val(function(i, v) {
    const pattern = /[^A-Za-z0-9]+/g;
    return v.replace(pattern, '').toLowerCase()
  })
}

function showPassword() {
  const toggler = $(event.target), target = $(toggler).prev()
  if($(target).attr('type') === 'text') {
    $(target).attr('type', 'password')
    $(toggler).children().replaceClass('bi-eye', 'bi-eye-slash')
  } else {
    $(target).attr('type', 'text')
    $(toggler).children().replaceClass('bi-eye-slash', 'bi-eye')
  }
}

$(document).ready(function() {
  $('.data-table, #dataTable').DataTable({
    language: {
        url: `${location.origin}${application}/assets/json/dataTables.i18n.id.json`,
    }
  })
})