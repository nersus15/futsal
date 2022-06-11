configTabel["<?= $id ?>"] = [
    { 
        mData: null,
    },
    { 
        data: 'nama'
    },
    { 
        data: 'url' 
    },
    {
        data: 'level'
    },
    { 
        data: 'jenis'
    },
    { 
        data: 'icon'
    },
    { 
        mRender: function (row, type, data){
            return data.aktif == 1 ? 'Aktif' : 'Non Aktif';
        }
    },
    {
        mRender: function(row, type, data){
            var perm = "-";
            if(data.permission){
                perm = "<ul>";
                for(let i =0; i < 5; i++){
                    if(data.permission[i])
                        perm += "<li>" + data.permission[i] + "</li>";
                }
                "</ul>";

                if(data.permission.length > 5){
                    perm += "<a href='#' class='more-info' data-id='" + data.id + "'>Tampilkan lebih banyak</a>";
                }
                              
            }
            return perm;
        }
    },{
        data: 'desc',
        sWidth: "20%",
    }
];