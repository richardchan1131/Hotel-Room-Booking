<div class="support-topic-search-banner">
    <div class="bc_banner" style="background-image: url('/uploads/demo/tour/banner-search.jpg')">
        <div class="container text-center">
            <h2 class="banner-title text-white text-heading text-center text-36">{{__("How Can We Help?")}}</h2>
            <p class="banner-desc text-white  sub-heading text-center text-18">{{__("Find out more topics")}}</p>
            <a href="{{route('support.ticket.index')}}" class="btn btn-primary" type="submit">
                <i class="fa fa-support"></i> {{__('Support Tickets')}}</a>
        </div>
    </div>
    <div class="bc_form_search">
        <div class="container">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class=" g-form-control">
                        <form class="banner-search form bravo_form" method="get" action="{{route('support.topic.index')}}">
                            <div class="g-field-search">
                                <div class="form-group">
                                    <div class="form-content">
                                        <input
                                            type="text" placeholder="{{__("Search topic...")}}" class="form-control" value="{{request('s')}}" name="s"
                                        >
                                    </div>
                                </div>
                            </div>
                            <div class="g-button-submit">
                                <button class="btn btn-primary btn-search" type="submit">{{__('Search')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
