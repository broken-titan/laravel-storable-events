<?php

    namespace BrokenTitan\StorableEvents\Providers;

    use BrokenTitan\StorableEvents\Contracts\ShouldStore;
    use Illuminate\Contracts\Support\Arrayable;
    use Illuminate\Support\Facades\Event;
    use Illuminate\Support\ServiceProvider;

    class StorableEventsServiceProvider extends ServiceProvider {
        public function boot() {
            $this->publishes([
                __DIR__ . "/../../config/storable-events.php" => config_path("storable-events.php")
            ], "config");

            Event::listen("*", function($name, $data) {
                $event = $data[0];
                if ($event instanceof ShouldStore) {
                    $data = array_map(function($property) {
                        return ($property instanceof Arrayable) ? $property->toArray() : $property;
                    }, get_object_vars($event));

                    $eventClass = config("storable-events.class");
                    $eventClass::create([
                        "class" => get_class($event), 
                        "data" => $data, 
                        "name" => class_basename($event)
                    ]);
                }
            });
        }
    }