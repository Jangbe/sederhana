$.ajax({
    type: "GET",
    url: "https://x.rajaapi.com/MeP7c5ne23EtRlULiNs4VmgNCpkdLrpWFUN1L2TuiOaKlpabWj40eX0cLb/m/wilayah/kecamatan/",
    data: { idkabupaten: 3206 },
    success: function (kec) {
        // console.log(kec.data);
        $.each(kec.data, function (k, v) {
            // console.log(v);
            kecam(v.id, v.name);
        });
    }
});
function kecam(id, kec) {
    $.ajax({
        type: "GET",
        url: "https://x.rajaapi.com/MeP7c5ne23EtRlULiNs4VmgNCpkdLrpWFUN1L2TuiOaKlpabWj40eX0cLb/m/wilayah/kelurahan/",
        data: { idkecamatan: id },
        success: function (kel) {
            // console.log(kel.data);
            $.each(kel.data, function (k, v) {
                insert(kec, v.name);
            });
        }
    });
}
function insert(kec, desa) {
    token = $('input:hidden').val();
    console.log(kec, desa);
    // console.log(token);
    $.ajax({
        method: "POST",
        url: "localhost:8000/ongkir",
        data: { _token: token, kec: kec, desa: desa },
        success: function (data) {
            console.log(data);
        }
    });
}