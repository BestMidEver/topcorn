<div class="modal fade" id="tutorial" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" ng-class="{'modal-lg':current_level>1 && current_level!=600}" role="document">

    <!--USERS MANUAL-->
    <div class="modal-content" ng-if="current_level < 2">
      <div class="modal-header">
        <h5 class="modal-title">{{ __('tutorial.users_manual') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>{{ __('tutorial.users_manual_1') }}</p>
        {!! __('tutorial.users_manual_2') !!}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" ng-click="level_up(1)">{{ __('tutorial.do_it_later') }}</button>
        <button type="button" class="btn btn-primary" ng-click="level_up(100)">{{ __('tutorial.start_course') }}</button>
      </div>
    </div>
    <!--USERS MANUAL-->



    <!--QUICK RATE-->
    <div class="modal-content" ng-if="(current_level > 99 && current_level < 200) || show_previous_tutorial == 'quick rate'">
      <div class="modal-header">
        <h5 class="modal-title">1 - {{ __('navbar.sequentialvote') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <ul class="list-group">
          <li class="list-group-item" ng-class="{'list-group-item-success':current_level > 100}">
            <div class="h6 text-muted">{{ __('tutorial.sequential_1') }}</div>
            {{ __('tutorial.sequential_2') }}
            <div class="h6 text-muted mt-4">{{ __('tutorial.sequential_3') }}</div>
            {!! __('tutorial.sequential_4') !!}
            <div class="py-2"><span class="text-muted">{{ __('tutorial.quest') }}: </span><span ng-class="{'badge badge-danger':current_level < 101}">{{ __('tutorial.sequential_mission') }}</span> <i class="fa fa-check" ng-show="current_level > 100"></i></div>
          </li>
          <li class="list-group-item" ng-class="{'list-group-item-success':current_level > 101}" ng-if="current_level > 100">
            <div class="h6 text-muted">{{ __('tutorial.sequential_5') }}</div>
            {{ __('tutorial.sequential_6') }}
            <div class="lead py-2">"{{ __('long_texts.the_question') }}"</div>
            {{ __('tutorial.sequential_7') }}
            <div class="py-2"><span class="badge badge-secondary">{{ __('general.havent_seen') }}</span> -> {{ __('tutorial.sequential_8') }}</div>
            <div class="py-2"><span class="badge badge-secondary">{{ __('general.definitely_dont_recommend') }}</span> -> {{ __('tutorial.sequential_9') }}</div>
            <div class="py-2"><span class="badge badge-secondary">{{ __('general.dont_recommend') }}</span> -> {{ __('tutorial.sequential_10') }}</div>
            <div class="py-2"><span class="badge badge-secondary">{{ __('general.not_sure') }}</span> -> {{ __('tutorial.sequential_11') }}</div>
            <div class="py-2"><span class="badge badge-secondary">{{ __('general.recommend') }}</span> -> {{ __('tutorial.sequential_12') }}</div>
            <div class="py-2"><span class="badge badge-secondary">{{ __('general.definitely_recommend') }}</span> -> {{ __('tutorial.sequential_13') }}</div>
            <div class="h6 text-muted mt-4">{{ __('tutorial.sequential_14') }}</div>
            <div class="py-2"><span class="text-muted">{{ __('tutorial.quest') }}: </span><span ng-class="{'badge badge-danger':current_level < 102}">{{ __('tutorial.sequential_mission_2') }}</span> <i class="fa fa-check" ng-show="current_level > 101"></i></div>
            <div class="mt-2"><small>{{ __('tutorial.sequential_15') }}</small></div>
            <div class="mt-2">{!! __('tutorial.sequential_16') !!}</div>
            <div class="mt-2">{!! __('tutorial.sequential_17') !!}</div>
            <div class="mt-2">{!! __('tutorial.sequential_18') !!}</div>
          </li>
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" ng-hide="current_level < 102" ng-click="level_up(200)">{{ __('tutorial.sequential_19') }}</button>
      </div>
    </div>
    <!--QUICK RATE-->




    <!--SEARCH-->
    <div class="modal-content" ng-if="((current_level > 199 && current_level < 300) && show_previous_tutorial != 'quick rate') || show_previous_tutorial == 'search'">
      <div class="modal-header">
        <h5 class="modal-title">2 - Arama Sayfası</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <ul class="list-group">
          <li class="list-group-item" ng-class="{'list-group-item-success':current_level > 200}">
            <div class="h6 text-muted">Sayfaya Erişim</div>
            Arama sayfasına ulaşmak için sayfanın en üstünde gezinti çubuğundaki <span class="badge badge-secondary"><i class="fa fa-search" aria-hidden="true"></i> Ara</span> veya sayfanın en altında altbilgisindeki <span class="badge badge-secondary">Film/Kişi/Kullanıcı Ara</span> linklerinden birine tıklayabilirsin.
            <div class="py-2"><span class="text-muted">Görev: </span><span ng-class="{'badge badge-danger':current_level < 201}">Arama sayfasına git.</span> <i class="fa fa-check" ng-show="current_level > 200"></i></div>
          </li>
          <li class="list-group-item" ng-class="{'list-group-item-success':current_level > 201}" ng-if="current_level > 200">
            <div class="h6 text-muted">Film Arama</div>
            Film aramak için <span class="badge badge-secondary">Film</span> sekmesinde arama çubuğuna aramak istediğin filmin adını yazabilirsin.
            <div class="py-2"><span class="text-muted">Görev: </span><span ng-class="{'badge badge-danger':current_level < 202}">Bir film ara.</span> <i class="fa fa-check" ng-show="current_level > 201"></i></div>
            <div class="h6 text-muted mt-4">Kişi Arama</div>
            Yönetmen, oyuncu, kameraman, yapımcı vb profesyonellerin hepsini kısaca kişi olarak adlandırdık. Kişi aramak için <span class="badge badge-secondary">Kişi</span> sekmesinde arama çubuğuna aramak istediğin kişinin adını yazabilirsin.
            <div class="h6 text-muted mt-4">Kullanıcı Arama</div>
            Topcorn kullanıcılarını aramak için <span class="badge badge-secondary">Kullanıcı</span> sekmesinde arama çubuğuna aramak istediğin kullanıcının adını veya e-postasını yazabilirsin.
          </li>
          <li class="list-group-item" ng-class="{'list-group-item-success':current_level > 202}" ng-if="current_level > 201">
            <div class="h6 text-muted">Aratılan Filmi Oylama</div>
            Film aradıktan sonra çıkan listede muhtemelen birçok filmin olduğu liste göreceksin. Bu filmlerden aradığın filmin altındaki çubuktan <span class="badge badge-secondary"><i class="fa fa-star-half-o" aria-hidden="true"></i> İzledim</span> tuşuna basıp "1 - Peş Peşe Oylama" dersinde öğrendiğin gibi oylayabilirsin.
            <div class="py-2"><span class="text-muted">Görev: </span><span ng-class="{'badge badge-danger':current_level < 203}">İzlediğin 1 filmi aratıp oyla.</span> <i class="fa fa-check" ng-show="current_level > 202"></i></div>
          </li>
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" ng-click="show_previous('quick rate');">Önceki Ders</button>
        <button type="button" class="btn btn-primary" ng-hide="current_level < 203" ng-click="level_up(300)">Sonraki Ders</button>
      </div>
    </div>
    <!--SEARCH-->




    <!--RECOMMENDATIONS-->
    <div class="modal-content" ng-if="((current_level > 299 && current_level < 400) && show_previous_tutorial != 'quick rate' && show_previous_tutorial != 'search') || show_previous_tutorial == 'recommendations'">
      <div class="modal-header">
        <h5 class="modal-title">3 - Film Tavsiyeleri</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <ul class="list-group">
          <li class="list-group-item" ng-class="{'list-group-item-success':current_level > 300}">
            <div class="h6 text-muted">Sayfaya Erişim</div>
            Tavsiyeler sayfasına ulaşmak için sayfanın en üstünde gezinti çubuğundaki <span class="badge badge-secondary"><i class="fa fa-th-list" aria-hidden="true"></i> Tavsiyeler</span> veya sayfanın en altında altbilgisindeki <span class="badge badge-secondary">Film Tavsiyeleri</span> linklerinden birine tıklayabilirsin.
            <div class="py-2"><span class="text-muted">Görev: </span><span ng-class="{'badge badge-danger':current_level < 301}">Tavsiyeler sayfasına git.</span> <i class="fa fa-check" ng-show="current_level > 300"></i></div>
          </li>
          <li class="list-group-item" ng-class="{'list-group-item-success':current_level > 301}" ng-if="current_level > 300">
            <div class="h6 text-muted">En Yüksek Oy Alan Filmler</div>
            <span class="badge badge-secondary">En Yüksek Oy Alan</span> sekmesinde en yüksek oyu alan filmleri görebilirsin.
            <div class="h6 text-muted mt-4">En Popüler Filmler</div>
            <span class="badge badge-secondary">En Popüler</span> sekmesinde en popüler filmleri görebilirsin.
            <div class="h6 text-muted mt-4">Benim Zevkime Göre <small>(Bu kısmı kullanmadan önce kursu tamamlamanızı öneriyoruz.)</small></div>
            Bu liste, Topcorn'u Topcorn yapan listedir. Yalnızca size özel film önerilerini burada bulabilirsiniz. Unutmayın, Topcorn'a ne kadar tutarlı ve çok bilgi verirseniz bu liste o ölçüde zengin ve size uygun olacaktır.
            Yalnızca senin zevkine göre seçilmiş filmleri görmek için <span class="badge badge-secondary">Benim Zevkime Göre</span> sekmesine tıklayabilirsin.
            <div class="h6 text-muted mt-4">Tavsiyelerdeki Filmleri Oylama</div>
            Muhtemelen birçok filmin olduğu liste göreceksin. Bu filmlerden izlediğin filmlerin altındaki çubuktan <span class="badge badge-secondary"><i class="fa fa-star-half-o" aria-hidden="true"></i> İzledim</span> tuşuna basıp "1 - Peş Peşe Oylama" dersinde öğrendiğin gibi oylayabilirsin.
            <div class="py-2"><span class="text-muted">Görev: </span><span ng-class="{'badge badge-danger':current_level < 302}">İzlediğin 1 filmi oyla.</span> <i class="fa fa-check" ng-show="current_level > 301"></i></div>
            <div class="h6 text-muted mt-4">Filmfiltre</div>
            <span class="badge badge-secondary"><i class="fa fa-filter" aria-hidden="true"></i> SÜZGEÇ</span> tuşuna basıp filtreyi ayarlayabilir; listedeki filmleri orijinal diline, türüne ve yılına göre daraltabilirsin.
          </li>
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" ng-click="show_previous('search');">Önceki Ders</button>
        <button type="button" class="btn btn-primary" ng-hide="current_level < 302" ng-click="level_up(400)">Son Ders</button>
      </div>
    </div>
    <!--RECOMMENDATIONS-->




    <!--VOTE MOVIES-->
    <div class="modal-content" ng-if="((current_level > 399 && current_level < 500) && show_previous_tutorial != 'quick rate' && show_previous_tutorial != 'search' && show_previous_tutorial != 'recommendations') || show_previous_tutorial == 'last mission'">
      <div class="modal-header">
        <h5 class="modal-title">4 - Son Görev</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <ul class="list-group">
          <li class="list-group-item" ng-class="{'list-group-item-success':current_level > 400}">
            <div class="h6 text-muted">Profilini Güçlendir</div>
            Peş Peşe Oylama, arama yapma veya tavsiye alma; hangisi kolayına geliyorsa onu kullanarak profilini güçlendirebilirsin.
            <div class="py-2"><span class="text-muted">Görev: </span><span ng-class="{'badge badge-danger':current_level < 401}">50 film oyla.</span> <i class="fa fa-check" ng-show="current_level > 400"></i></div>
          </li>
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" ng-click="show_previous('recommendations);">Önceki Ders</button>
        <button type="button" class="btn btn-primary" ng-hide="current_level < 401" ng-click="level_up(500)">Mezuniyet</button>
      </div>
    </div>
    <!--VOTE MOVIES-->




    <!--GRADUATION-->
    <div class="modal-content" ng-if="current_level > 499 && current_level < 600 && show_previous_tutorial != 'quick rate' && show_previous_tutorial != 'search' && show_previous_tutorial != 'recommendations' && show_previous_tutorial != 'last mission'">
      <div class="modal-header">
        <h5 class="modal-title">5 - Mezuniyet</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <ul class="list-group">
          <li class="list-group-item" ng-class="{'list-group-item-success':current_level > 500}">
            <div class="h6 text-muted">Ayarlar Sayfasına Erişim</div>
            Ayarlar sayfasına ulaşmak için sayfanın en üstünde gezinti çubuğundaki <span class="badge badge-secondary"><i class="fa fa fa-caret-down" aria-hidden="true"></i></span> > <span class="badge badge-secondary">Ayarlar</span> veya sayfanın en altında altbilgisindeki <span class="badge badge-secondary">Ayarlar</span> linklerinden birine tıklayabilirsin.
            <div class="py-2"><span class="text-muted">Görev: </span><span ng-class="{'badge badge-danger':current_level < 501}">Ayarlar sayfasına git.</span> <i class="fa fa-check" ng-show="current_level > 500"></i></div>
          </li>
          <li class="list-group-item" ng-class="{'list-group-item-success':current_level > 501}" ng-if="current_level > 500">
            <div class="h6 text-muted">Kapak Fotoğrafı Seçme</div>
            Kapak fotoğrafı açılır listesinden en çok beğendiğin filmlerden birinin kapak fotoğrafını kendi kapak fotoğrafın olarak belirleyebilirsin.
            <div class="py-2"><span class="text-muted">Görev: </span><span ng-class="{'badge badge-danger':current_level < 502}">Bir kapak fotoğrafı seç.</span> <i class="fa fa-check" ng-show="current_level > 501"></i></div>
          </li>
          <li class="list-group-item" ng-class="{'list-group-item-success':current_level > 502}" ng-if="current_level > 501">
            <div class="h6 text-muted">Profil Fotoğrafı Seçme</div>
            Kapak fotoğrafı seçtikten sonra, o filmde oynayan oyunculardan birinin profil fotoğrafını; ya da facebook ile giriş yaptıysan facebook profil fotoğrafını profil fotoğrafı açılır listesinden belirleyebilirsin.
            <div class="py-2"><span class="text-muted">Görev: </span><span ng-class="{'badge badge-danger':current_level < 503}">Bir profil fotoğrafı seç.</span> <i class="fa fa-check" ng-show="current_level > 502"></i></div>
          </li>
          <li class="list-group-item" ng-class="{'list-group-item-success':current_level > 503}" ng-if="current_level > 502">
            <div class="h6 text-muted">Değişiklikleri Kaydetme</div>
            Profilini ayarladıktan sonra değişiklikleri kaydetmek için <span class="badge badge-secondary">Değişiklikleri Kaydet</span> tuşuna basabilirsin.
            <div class="py-2"><span class="text-muted">Görev: </span><span ng-class="{'badge badge-danger':current_level < 504}">Değişiklikleri kaydet.</span> <i class="fa fa-check" ng-show="current_level > 503"></i></div>
          </li>
          <li class="list-group-item" ng-class="{'list-group-item-success':current_level > 504}" ng-if="current_level > 503">
            <div class="h6 text-muted">Profil Sayfasına Erişim</div>
            Kendi profilini görmek için sayfanın en üstünde gezinti çubuğundaki <span class="badge badge-secondary"><i class="fa fa-user-circle-o" aria-hidden="true"></i> Profilim</span> veya sayfanın en altında altbilgisindeki <span class="badge badge-secondary">Profilim</span> linklerinden birine tıklayabilirsin.
            <div class="py-2"><span class="text-muted">Yeni Görev: </span><span ng-class="{'badge badge-danger':current_level < 505}">Profil sayfana git.</span> <i class="fa fa-check" ng-show="current_level > 504"></i></div>
          </li>
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" ng-click="show_previous('last mission');">Önceki Ders</button>
        <button type="button" class="btn btn-primary" ng-hide="current_level < 505" ng-click="level_up(600)">Diplomanı Al</button>
      </div>
    </div>
    <!--GRADUATION-->




    <!--CONGRATULATIONS-->
    <div class="modal-content" ng-if="current_level == 600">
      <div class="modal-header">
        <h5 class="modal-title">Tebrikler</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Artık Topcorn'un temel özelliklerini biliyorsun. Profilini daha da güçlendir ve sana özel film önerilerinin tadını çıkart.</p>
        <p>Bu kursta öğrendiklerine ve daha fazlasına ulaşmak istersen sayfanın en altında altbilgisindeki <span class="badge badge-secondary">Sıkça Sorulan Sorular</span> linkine tıklayabilirsin.</p>
        <div class="py-2"><span class="text-muted">Görev: </span><span class="badge badge-danger">Şaka şaka, haydi durma kepini fırlat :)</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" ng-click="level_up(700)">Kepini Fırlat</button>
      </div>
    </div>
    <!--CONGRATULATIONS-->

  </div>
</div>