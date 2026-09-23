$(function () {
    // Initialize draggable
    $('.task').draggable({
        containment: '.board',
        cursor: 'grab',
        revert: 'invalid',
        zIndex: 9999,
        helper: function () {
            return $(this).clone().css({
                'width': $(this).outerWidth(),
                'opacity': 0.8,
                'pointer-events': 'none',
                'background-color': 'rgba(43, 182, 115, 0.2)',
                'box-shadow': '0 4px 15px rgba(0,0,0,0.2)'
            });
        },
        start: function () {
            $(this).addClass('dragging');
        },
        stop: function () {
            $(this).removeClass('dragging');
        }
    });

    // Initialize droppable
    $('.column').droppable({
        accept: '.task',
        hoverClass: 'droppable-hover',
        tolerance: 'pointer',
        over: function () {
            $(this).addClass('highlight');
        },
        out: function () {
            $(this).removeClass('highlight');
        },
        drop: function (event, ui) {
            const dragged = ui.draggable;
            const newStatus = $(this).data('status');
            const inquiryId = dragged.data('id');
            $(this).removeClass('highlight');

            if (newStatus === 'hold') {
                $('#holdModal').data('inquiry-id', inquiryId).modal('show');
                return;
            } else if (newStatus === 'reject') {
                $('#rejectModal').data('inquiry-id', inquiryId).modal('show');
                return;
            } else if (newStatus === 'active') {
                $('#activeModal').data('inquiry-id', inquiryId).modal('show');
                return; // prevent auto move
            }


            updateInquiryStatus(inquiryId, newStatus);
            moveTaskToColumn(dragged, newStatus, $(this));
        }
    });

    function moveTaskToColumn(task, status, targetColumn) {
        task.removeClass('active pending hold reject').addClass(status);
        task.attr('data-status', status);
        task.css('border-left-color', getStatusColor(status));
        targetColumn.find('.column-content').append(task);
    }

    function updateInquiryStatus(id, status, extraData = {}) {
        $.ajax({
            url: `/inquiries/update/${id}`,
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                status: status,
                ...extraData
            },
            success: function (res) {
                iziToast.success({
                    title: 'Success',
                    message: res.message || 'Inquiry status updated successfully!',
                    position: 'topRight',
                    timeout: 3000
                });
            },
            error: function (err) {
                iziToast.error({
                    title: 'Error',
                    message: err.responseJSON?.message || 'Something went wrong.',
                    position: 'topRight',
                    timeout: 4000
                });
            }
        });
    }

    function getStatusColor(status) {
        return {
            'active': '#4bc0c0',
            'pending': '#ff9f40',
            'hold': '#9966ff',
            'reject': '#ff4757'
        }[status] || '#2bb673';
    }

    $('#holdForm').on('submit', function (e) {
        e.preventDefault();
        const id = $('#holdModal').data('inquiry-id');
        const reason = $('#holdReason').val();
        const revisitDate = $('#revisitDate').val();
        const task = $(`.task[data-id="${id}"]`);
        const targetColumn = $('.column.hold');

        updateInquiryStatus(id, 'hold', { reason, revisit_date: revisitDate });
        moveTaskToColumn(task, 'hold', targetColumn);
        $('#holdModal').modal('hide');
        this.reset();
    });

    $('#rejectForm').on('submit', function (e) {
        e.preventDefault();
        const id = $('#rejectModal').data('inquiry-id');
        const reason = $('#rejectReason').val();
        const task = $(`.task[data-id="${id}"]`);
        const targetColumn = $('.column.reject');

        updateInquiryStatus(id, 'reject', { reason });
        moveTaskToColumn(task, 'reject', targetColumn);
        $('#rejectModal').modal('hide');
        this.reset();
    });

    $('#activeForm').on('submit', function (e) {
        e.preventDefault();
        const id = $('#activeModal').data('inquiry-id');
        const activeTime = $('#activeTime').val();
        const task = $(`.task[data-id="${id}"]`);
        const targetColumn = $('.column.active');

        console.log(activeTime, task)
        updateInquiryStatus(id, 'active', { datetime: activeTime });
        moveTaskToColumn(task, 'active', targetColumn);
        $('#activeModal').modal('hide');
        this.reset();
    });

    $(document).on('submit', '#deleteInquiry', function (e) {
        e.preventDefault();
        const encryptedId = $(this).find('.encrypted-id').val();

        if (!encryptedId) {
            return iziToast.error({ title: 'Error', message: 'ID not found' });
        }

        $.ajax({
            url: '/inquiries/delete',
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                encrypted_id: encryptedId
            },
            success: function () {
                iziToast.error({ title: 'Deleted', message: 'Record Deleted successfully' });
                $(e.target).closest('.task, .inquiry-card, tr').remove();
            },
            error: function (xhr) {
                iziToast.error({ title: 'Error', message: xhr.responseJSON?.message || 'Something went wrong!' });
            }
        });
    });


    function makeAllConsultsSeen(){
        console.log('Executing Scripts');
        $.ajax({
            url: '/inquiries/makeconsultsseen',
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(res){
                console.log(res.message);
            },
            error: function(xhr){
                console.log(xhr.responseJSON?.message || xhr.statusText);
            }
        })
    }

    $(document).ready(function(){
        setTimeout(makeAllConsultsSeen, 2000);
    })
});