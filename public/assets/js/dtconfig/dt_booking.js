configTabel["<?= $id ?>"] = [
    { 
        mData: null,
    },
    { 
        mRender: function(row, type, data){
            return data.lapangan + " (" + data.jenis + ") - " + data.tempat
        }
    },
    {
      mRender: function(row, type, data){
          return data.tanggal + " Jam " + data.mulai + " - " + data.selesai
      }  
    },
    {
        mRender: function(row, type, data){
            return data.mtim ? data.mtim : data.tim;
        }
    },
    {
        mRender: function(row, type, data){
            return data.mwakil ? data.mwakil : data.wakil;
        }
    },
    {
        data: 'dibuat',
    },
    {
        mRender: function(row, type, data){
            return data.mid ? data.mid : "Bukan Member";
        }
    },
    {
        mRender: function(row, type, data){
            return "Rp. " + data.tarif.rupiahFormat();
        }
    },
    {
        mRender: function(row, type, data){
            if(!data.diskon) data.diskon = 0;
            var diskon = (parseInt(data.tarif) * parseInt(data.diskon))/100;
            return data.mid ?  data.diskon  +'% - ' + 'Rp. ' + diskon.toString().rupiahFormat() : '-';
        }
    },
    {
        mRender: function(row, type, data){
            if(!data.diskon) data.diskon = 0;
            var diskon = (parseInt(data.tarif) * parseInt(data.diskon))/100;
            return data.mid ? 'Rp. ' + (parseInt(data.tarif) - diskon).toString().rupiahFormat() : 'Rp. ' + data.tarif.rupiahFormat();
        }
    }, 
    {
        data: 'status'
    },
    {
        mRender: function(row, type, data){
            return data.bukti_bayar ? "<a target='_blank' href='"+ path + "/public/assets/img/bukti/" + data.bukti_bayar +"'><img style='width: 100%' src='" + path + "/public/assets/img/bukti/" + data.bukti_bayar + "'/></a>" : "Belum Bayar";
        }
    }
];
