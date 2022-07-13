configTabel["<?= $id ?>"] = [
    { 
        mData: null,
    },
    { 
        data: 'lapangan'
    },
    {
        mRender: function(row, type, data){
            return data.mulai + " - " + data.selesai;
        }
    },
    { 
        data: 'jenis'
    },
    {
        data: 'tempat'
    },
    {
        mRender: function(row, type, data){
            if(data && data.tarif) return "Rp. " + data.tarif.rupiahFormat()
        }
    }
];