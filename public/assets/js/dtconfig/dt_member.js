configTabel["<?= $id ?>"] = [
    { 
        mData: null,
    },
    { 
        data: 'tim'
    },
    {
       data: 'penanggung_jawab'
    },
    {
        data: 'hp'
    },
    {
        data: 'email'
    },
    { 
        data: 'asal'
    },
    {
        data: 'dibuat'
    },
    {
        data: 'username'
    },
    {
        mRender: function(row, type, data){
            return data.id + data.dibuat.split(' ')[0].replaceAll('-', '')
        }
    }
];