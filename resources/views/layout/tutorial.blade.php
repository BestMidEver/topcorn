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
            {{ __('tutorial.sequential_1') }}
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
        <button type="button" class="btn btn-primary" ng-hide="current_level < 102" ng-click="level_up(200)">{{ __('tutorial.next_lesson') }}</button>
      </div>
    </div>
    <!--QUICK RATE-->




    <!--SEARCH-->
    <div class="modal-content" ng-if="((current_level > 199 && current_level < 300) && show_previous_tutorial != 'quick rate') || show_previous_tutorial == 'search'">
      <div class="modal-header">
        <h5 class="modal-title">2 - {{ __('tutorial.search_page') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <ul class="list-group">
          <li class="list-group-item" ng-class="{'list-group-item-success':current_level > 200}">
            <div class="h6 text-muted">{{ __('tutorial.reach_page') }}</div>
            {!! __('tutorial.search_page_1') !!}
            <div class="py-2"><span class="text-muted">{{ __('tutorial.quest') }}: </span><span ng-class="{'badge badge-danger':current_level < 201}">{{ __('tutorial.search_mission') }}</span> <i class="fa fa-check" ng-show="current_level > 200"></i></div>
          </li>
          <li class="list-group-item" ng-class="{'list-group-item-success':current_level > 201}" ng-if="current_level > 200">
            <div class="h6 text-muted">{{ __('tutorial.search_page_2') }}</div>
            {!! __('tutorial.search_page_3') !!}
            <div class="py-2"><span class="text-muted">{{ __('tutorial.quest') }}: </span><span ng-class="{'badge badge-danger':current_level < 202}">{{ __('tutorial.search_mission_2') }}</span> <i class="fa fa-check" ng-show="current_level > 201"></i></div>
            <div class="h6 text-muted mt-4">{{ __('tutorial.search_page_4') }}</div>
            {!! __('tutorial.search_page_5') !!}
            <div class="h6 text-muted mt-4">{{ __('tutorial.search_page_6') }}</div>
            {!! __('tutorial.search_page_7') !!}
          </li>
          <li class="list-group-item" ng-class="{'list-group-item-success':current_level > 202}" ng-if="current_level > 201">
            <div class="h6 text-muted">{{ __('tutorial.search_page_8') }}</div>
            {!! __('tutorial.search_page_9') !!}
            <div class="py-2"><span class="text-muted">{{ __('tutorial.quest') }}: </span><span ng-class="{'badge badge-danger':current_level < 203}">{{ __('tutorial.search_mission_3') }}</span> <i class="fa fa-check" ng-show="current_level > 202"></i></div>
          </li>
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" ng-click="show_previous('quick rate')">{{ __('tutorial.previous_lesson') }}</button>
        <button type="button" class="btn btn-primary" ng-hide="current_level < 203" ng-click="level_up(300)">{{ __('tutorial.next_lesson') }}</button>
      </div>
    </div>
    <!--SEARCH-->




    <!--RECOMMENDATIONS-->
    <div class="modal-content" ng-if="((current_level > 299 && current_level < 400) && show_previous_tutorial != 'quick rate' && show_previous_tutorial != 'search') || show_previous_tutorial == 'recommendations'">
      <div class="modal-header">
        <h5 class="modal-title">3 - {{ __('tutorial.recommendations') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <ul class="list-group">
          <li class="list-group-item" ng-class="{'list-group-item-success':current_level > 300}">
            <div class="h6 text-muted">{{ __('tutorial.reach_page') }}</div>
            {!! __('tutorial.recommendations_1') !!}
            <div class="py-2"><span class="text-muted">{{ __('tutorial.quest') }}: </span><span ng-class="{'badge badge-danger':current_level < 301}">{{ __('tutorial.recommendations_mission') }}</span> <i class="fa fa-check" ng-show="current_level > 300"></i></div>
          </li>
          <li class="list-group-item" ng-class="{'list-group-item-success':current_level > 301}" ng-if="current_level > 300">
            <div class="h6 text-muted">{{ __('tutorial.recommendations_2') }}</div>
            {!! __('tutorial.recommendations_3') !!}
            <div class="h6 text-muted mt-4">{{ __('tutorial.recommendations_4') }}</div>
            {!! __('tutorial.recommendations_5') !!}
            <div class="h6 text-muted mt-4">{!! __('tutorial.recommendations_6') !!}</div>
            {!! __('tutorial.recommendations_7') !!}
            <div class="h6 text-muted mt-4">{{ __('tutorial.recommendations_8') }}</div>
            {!! __('tutorial.recommendations_9') !!}
            <div class="py-2"><span class="text-muted">{{ __('tutorial.quest') }}: </span><span ng-class="{'badge badge-danger':current_level < 302}">{{ __('tutorial.recommendations_mission_1') }}</span> <i class="fa fa-check" ng-show="current_level > 301"></i></div>
            <div class="h6 text-muted mt-4">{{ __('tutorial.recommendations_10') }}</div>
            {!! __('tutorial.recommendations_11') !!}
          </li>
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" ng-click="show_previous('search')">{{ __('tutorial.previous_lesson') }}</button>
        <button type="button" class="btn btn-primary" ng-hide="current_level < 302" ng-click="level_up(400)">{{ __('tutorial.next_lesson') }}</button>
      </div>
    </div>
    <!--RECOMMENDATIONS-->




    <!--VOTE MOVIES-->
    <div class="modal-content" ng-if="((current_level > 399 && current_level < 500) && show_previous_tutorial != 'quick rate' && show_previous_tutorial != 'search' && show_previous_tutorial != 'recommendations') || show_previous_tutorial == 'last mission'">
      <div class="modal-header">
        <h5 class="modal-title">4 - {{ __('tutorial.last_quest') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <ul class="list-group">
          <li class="list-group-item" ng-class="{'list-group-item-success':current_level > 400}">
            <div class="h6 text-muted">{{ __('tutorial.last_quest_1') }}</div>
            {{ __('tutorial.last_quest_2') }}
            <div class="py-2"><span class="text-muted">{{ __('tutorial.last_quest') }}: </span><span ng-class="{'badge badge-danger':current_level < 401}">{{ __('tutorial.last_quest_mission') }}</span> <i class="fa fa-check" ng-show="current_level > 400"></i></div>
          </li>
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" ng-click="show_previous('recommendations);">{{ __('tutorial.previous_lesson') }}</button>
        <button type="button" class="btn btn-primary" ng-hide="current_level < 401" ng-click="level_up(500)">{{ __('tutorial.last_quest_3') }}</button>
      </div>
    </div>
    <!--VOTE MOVIES-->




    <!--GRADUATION-->
    <div class="modal-content" ng-if="current_level > 499 && current_level < 600 && show_previous_tutorial != 'quick rate' && show_previous_tutorial != 'search' && show_previous_tutorial != 'recommendations' && show_previous_tutorial != 'last mission'">
      <div class="modal-header">
        <h5 class="modal-title">5 - {{ __('tutorial.settings') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <ul class="list-group">
          <li class="list-group-item" ng-class="{'list-group-item-success':current_level > 500}">
            <div class="h6 text-muted">{{ __('tutorial.settings_1') }}</div>
            {!! __('tutorial.settings_2') !!}
            <div class="py-2"><span class="text-muted">{{ __('tutorial.quest') }}: </span><span ng-class="{'badge badge-danger':current_level < 501}">{{ __('tutorial.settings_mission') }}</span> <i class="fa fa-check" ng-show="current_level > 500"></i></div>
          </li>
          <li class="list-group-item" ng-class="{'list-group-item-success':current_level > 501}" ng-if="current_level > 500">
            <div class="h6 text-muted">{{ __('tutorial.settings_3') }}</div>
            {{ __('tutorial.settings_4') }}
            <div class="py-2"><span class="text-muted">{{ __('tutorial.quest') }}: </span><span ng-class="{'badge badge-danger':current_level < 502}">{{ __('tutorial.settings_mission_2') }}</span> <i class="fa fa-check" ng-show="current_level > 501"></i></div>
          </li>
          <li class="list-group-item" ng-class="{'list-group-item-success':current_level > 502}" ng-if="current_level > 501">
            <div class="h6 text-muted">{{ __('tutorial.settings_5') }}</div>
            {{ __('tutorial.settings_6') }}
            <div class="py-2"><span class="text-muted">{{ __('tutorial.quest') }}: </span><span ng-class="{'badge badge-danger':current_level < 503}">{{ __('tutorial.settings_mission_3') }}</span> <i class="fa fa-check" ng-show="current_level > 502"></i></div>
          </li>
          <li class="list-group-item" ng-class="{'list-group-item-success':current_level > 503}" ng-if="current_level > 502">
            <div class="h6 text-muted">{{ __('tutorial.settings_7') }}</div>
            {!! __('tutorial.settings_8') !!}
            <div class="py-2"><span class="text-muted">{{ __('tutorial.quest') }}: </span><span ng-class="{'badge badge-danger':current_level < 504}">{{ __('tutorial.settings_mission_4') }}</span> <i class="fa fa-check" ng-show="current_level > 503"></i></div>
          </li>
          <li class="list-group-item" ng-class="{'list-group-item-success':current_level > 504}" ng-if="current_level > 503">
            <div class="h6 text-muted">{{ __('tutorial.settings_9') }}</div>
            {!! __('tutorial.settings_10') !!}
            <div class="py-2"><span class="text-muted">{{ __('tutorial.quest') }}: </span><span ng-class="{'badge badge-danger':current_level < 505}">{{ __('tutorial.settings_mission_5') }}</span> <i class="fa fa-check" ng-show="current_level > 504"></i></div>
          </li>
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" ng-click="show_previous('last mission')">{{ __('tutorial.previous_lesson') }}</button>
        <button type="button" class="btn btn-primary" ng-hide="current_level < 505" ng-click="level_up(600)">{{ __('tutorial.settings_11') }}</button>
      </div>
    </div>
    <!--GRADUATION-->




    <!--CONGRATULATIONS-->
    <div class="modal-content" ng-if="current_level == 600">
      <div class="modal-header">
        <h5 class="modal-title">{{ __('tutorial.gratz') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>{{ __('tutorial.gratz_1') }}</p>
        <p>{!! __('tutorial.gratz_2') !!}</p>
        <div class="py-2"><span class="text-muted">{{ __('tutorial.quest') }}: </span><span class="badge badge-danger">{{ __('tutorial.gratz_mission') }}</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" ng-click="level_up(700)">{{ __('tutorial.gratz_3') }}</button>
      </div>
    </div>
    <!--CONGRATULATIONS-->

  </div>
</div>