<tbody id="body-table-childService">
    @foreach ($childService as $row)
    <tr>
        <td>
            {{ $row->id }}
        </td>
        <td>{{ $row->name }}</td>
        <td>
            {{ number_format($row->cost) }} đ
        </td>
        <td>
            {{ $row->type_pet }}
        </td>
        @if ($roleAccount === 'admin')
        <td class="table-td-center">
            <a> <button onclick="deleteFetch('{{ $row->id }}')" style="font-size:2vw;font-size:2vh"
                    class="btn btn-danger btn-sm trash" type="button" title="Xóa">
                    <i class="fas fa-trash-alt"></i>
                </button></a>
            <button
                onclick="showDetailChildService('{{ $row->name }}','{{ $row->cost }}','{{ $row->id }}','{{ $row->type_pet }}')"
                style="font-size:2vw;font-size:2vh" data-bs-toggle="modal" data-bs-target="#update-child"
                class="btn btn-success btn-sm edit" type="button" title="Sửa" id="show-emp">Sửa
            </button>
            {{-- modal cập nhật thông tin gói dịch vụ --}}
            <!-- Modal xóa -->
            <div class="modal fade" id="update-child" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">
                                Cập nhật thông tin
                            </h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="FormUpdateChildService" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="d-flex flex-column">
                                    <input hidden value="" id="IdChildServiceHidden">
                                    <div class="d-flex">
                                        <h6>Tên gói: </h6>
                                        <input class=" ms-2 mb-3 form-control w-60" placeholder="Nhập tên dịch vụ ..."
                                            style="border:1px solid black" name="childServiceModal"
                                            id="NamechildServiceModal" type="text">
                                    </div>
                                    <div class="d-flex">
                                        <h6>Giá </h6>
                                        <input class="ms-4 mb-3 form-control " placeholder="Nhập giá dịch vụ ..."
                                            style="border:1px solid black" name="childServiceModal"
                                            id="CostchildServiceModal" type="text">
                                    </div>
                                    <p class="align-items-start">Loại thú cưng</p>
                                    <select name="TypePetchildServiceModal" id="TypePetchildServiceModal"
                                        class="form-select w-25" style="border:1px solid black">
                                        <option selected>Chó</option>
                                        <option>Mèo</option>
                                        <option>Khác</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">Cập nhật</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </td>
        @endif
    </tr>
    @endforeach
</tbody>