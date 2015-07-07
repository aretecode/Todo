#TESTS
//////////////////////////////////////////////////////////////////////////
//  not used, just was for copy paste example
//////////////////////////////////////////////////////////////////////////

use Arbiter\ActionFactory;
use Aura\Router\Matcher;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Arbiter\Action;
use Aura\Di\ContainerBuilder;
use Radar\Adr\Resolver;
use Radar\Adr\Route;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequestFactory;
use Aura\Router\Map;
use Aura\Router\RouterContainer;



use Arbiter\ActionHandler as Arbiter;

class ActionHandler extends Arbiter
{
    public function __invoke(Request $request, ResponseInterface $response, callable $next)
    {
        $action = $request->getAttribute('radar/adr:action');
        $request = $request->withoutAttribute('radar/adr:action');
        $response = $this->handle($action, $request, $response);
        return $next($request, $response);
    }
}
class RoutingHandler
{
    protected $actionFactory;
    protected $matcher;

    public function __construct(Matcher $matcher, ActionFactory $actionFactory)
    {
        $this->matcher = $matcher;
        $this->actionFactory = $actionFactory;
    }

    public function __invoke(Request $request, ResponseInterface $response, callable $next)
    {
        $request = $this->routeRequest($request);
        return $next($request, $response);
    }

    protected function routeRequest(Request $request)
    {
        $route = $this->matcher->match($request);

        if (! $route) {
            return $request->withAttribute(
                'radar/adr:action',
                $this->actionFactory->newInstance(
                    null,
                    [$this->matcher, 'getFailedRoute'],
                    'Radar\Adr\Responder\RoutingFailedResponder'
                )
            );
        }

        foreach ($route->attributes as $key => $val) {
            $request = $request->withAttribute($key, $val);
        }

        return $request->withAttribute(
            'radar/adr:action',
            $this->actionFactory->newInstance(
                $route->input,
                $route->domain,
                $route->responder
            )
        );
    }
}
/*
    protected $relayBuilder;
    protected $fakeMap;
    protected $fakeRules;
    protected function setUpADR_Manually() {
        $builder = new ContainerBuilder();
        $di = $builder->newInstance(true); // added true
        $resolver = new Resolver($di->getInjectionFactory());

        // was FakeMap
        $this->fakeMap = new Aura\Router\Map(new Route());
        $this->fakeRules = new RuleIterator();
        $this->relayBuilder = new RelayBuilder($resolver);

        $this->adr = new Adr(
            $this->fakeMap,
            $this->fakeRules,
            $this->relayBuilder
        );
    }
*/

// put this in later just for the example maybe
class FakeMiddleware
{
    public static $count;

    public function __invoke($request, $response, $next)
    {
        $response->getBody()->write(++ static::$count);
        $response = $next($request, $response);
        $response->getBody()->write(++ static::$count);
        return $response;
    }
}



#REFACTOR 
//////////////////////////////////////////////////////////////////////////
// should it be refactored like this?
//////////////////////////////////////////////////////////////////////////
    use Arbiter\ActionFactory;
    use Arbiter\ActionHandler;
    use Arbiter\Action;

    ///// SETTING UP
    $actionFactory = new ActionFactory();
    $resolver = function ($spec) {
        // this fake resolver just returns the spec directly
        return $spec;
    };
    $actionHandler = new ActionHandler($resolver); 

    ///// INPUT STUFF
    $input = function ($request) {
        return [$request->getQueryParams()['noun']];
    };
    $domain = function ($noun) {
        return "Hello $noun";
    };
    $responder = function ($request, $response, $payload) {
        $response->getBody()->write($payload . " eh");
        return $response;
    };

    // aka, newAction
    $action = $actionFactory->newInstance($input, $domain, $responder);

    $_GET['noun'] = 'worlds';
    // USER|userID HERE?
    // $this->assertResponse($action, 'Hello world');

    ///// REQUEST STUFF
    $request = ServerRequestFactory::fromGlobals();
    $response = $actionHandler->handle(
        $action,
        $request,
        new Response()
    );


#INPUT
//////////////////////////////////////////////////////////////////////////
    I don't know whether to put the Cookie stuff in here to pass in as input for the User?

    // $data = $request->getParsedBody();
    // $cookies = $request->getCookieParams();
    // $return =  ['id' => $id, 'data' => $data, 'cookies' => $cookies];
    // var_dump($return); flush();
    // return $return;
    // could be like Category or Tag or something


    class UserInput extends Input
    {
        public function __invoke(Request $request)
        {    	
            return $cookies = $request->getCookieParams();
        }
    }


#MAPPER
//////////////////////////////////////////////////////////////////////////
    Create Read Update Delete 
    Add    Get  Edit   Delete


    Exceptions could also be Event driven and attempt to resolve?