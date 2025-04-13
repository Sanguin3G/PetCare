$("#searchProduct").on("change", function () {
    // Lấy từ khóa tìm kiếm, chuyển về chữ thường và loại bỏ dấu cách thừa
    let searchTerm = $(this).val().toLowerCase().trim();

    // Lặp qua từng hàng trong bảng
    $("#table-product tr").each(function () {
        // Lấy nội dung cột namePro (cột thứ 2, index 1)
        let namePro = $(this).find("td:eq(1)").text().toLowerCase();

        // Kiểm tra xem namePro có chứa từ khóa không
        if (namePro.includes(searchTerm) || searchTerm === "") {
            $(this).show(); // Hiển thị hàng nếu khớp hoặc từ khóa rỗng
        } else {
            $(this).hide(); // Ẩn hàng nếu không khớp
        }
    });
});
