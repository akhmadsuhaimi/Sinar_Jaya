<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <strong>SINAR JAYA</strong>
        </div>
        <div>
            <h4 class="logo-text"></h4>
        </div>
        <div class="toggle-icon ms-auto"><i class="lni lni-menu"></i>
        </div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        <li>
            <a href="{{ url('dashboard') }}">
                <div class="parent-icon"><i class='bx bx-home'></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>
        @if (auth()->user()->level == 'admin')
            <li>
                <a href="{{ url('stok') }}">
                    <div class="parent-icon"><i class='bx bx-receipt'></i>
                    </div>
                    <div class="menu-title">Stok</div>
                </a>
            </li>
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="fadeIn animated bx bx-detail"></i>
                    </div>
                    <div class="menu-title">Transaksi</div>
                </a>
                <ul>
                    <li> <a href="{{ route('pembelian.index') }}"><i class="bx bx-right-arrow-alt"></i>Pembelian</a>
                    </li>
                    <li> <a href="{{ route('penjualan.index') }}"><i class="bx bx-right-arrow-alt"></i>Penjualan</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="fadeIn animated bx bx-detail"></i>
                    </div>
                    <div class="menu-title">Data Master</div>
                </a>
                <ul>
                    <li> <a href="{{ route('jenisproduk.index') }}"><i class="bx bx-right-arrow-alt"></i>Jenis
                            Produk</a>
                    </li>
                    <li> <a href="{{ route('perhiasan.index') }}"><i class="bx bx-right-arrow-alt"></i>Data
                            Perhiasan</a>
                    </li>
                    <li> <a href="{{ route('user.index') }}"><i class="bx bx-right-arrow-alt"></i>User</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="fadeIn animated bx bx-detail"></i>
                    </div>
                    <div class="menu-title">Naive Bayes</div>
                </a>
                <ul>
                    <li> <a href="{{ route('datasets.index') }}"><i class="bx bx-right-arrow-alt"></i>Data Set</a>
                    </li>
                    <li> <a href="{{ route('data-uji.index') }}"><i class="bx bx-right-arrow-alt"></i>Data Uji</a>
                    </li>
                    <li> <a href="{{ route('penjualan.prediksi') }}"><i class="bx bx-right-arrow-alt"></i>Prediksi</a>
                    </li>
                    <li> <a href="{{ route('hasil-prediksi.index') }}"><i class="bx bx-right-arrow-alt"></i>Hasil Prediksi</a>
                    </li>
                    <li> <a href="{{ route('performance.index') }}"><i
                                class="bx bx-right-arrow-alt"></i>Performance</a>
                    </li>
                </ul>
            </li>
        @endif
        <!--------------------------------------------------------------------------------->
        @if (auth()->user()->level == 'pimpinan')
            <li>
                <a href="{{ url('stok') }}">
                    <div class="parent-icon"><i class='bx bx-receipt'></i>
                    </div>
                    <div class="menu-title">Laporan Stok</div>
                </a>
            </li>
            <li>
                <a href="{{ route('hasil-prediksi.index') }}">
                    <div class="parent-icon"><i class='fadeIn animated bx bx-detail'></i>
                    </div>
                    <div class="menu-title">Laporan Hasil Prediksi Naive Bayes</div>
                </a>
            </li>
            <li>
                <a href="{{ route('penjualan.index') }}">
                    <div class="parent-icon"><i class='fadeIn animated bx bx-detail'></i>
                    </div>
                    <div class="menu-title">Laporan Hasil Penjualan</div>
                </a>
            </li>
            <li>
                <a href="{{ route('pembelian.index') }}">
                    <div class="parent-icon"><i class='fadeIn animated bx bx-detail'></i>
                    </div>
                    <div class="menu-title">Laporan Hasil Pembelian</div>
                </a>
            </li>
        @endif
    </ul>
</div>
