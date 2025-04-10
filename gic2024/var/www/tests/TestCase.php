protected function setUp(): void
{
    parent::setUp();
    
    // Mock the Vite facade for testing
    $this->mockVite();
}

protected function mockVite()
{
    $viteMock = Mockery::mock('Illuminate\Foundation\Vite');
    $viteMock->shouldReceive('__invoke')->andReturn('');
    $this->app->instance(Illuminate\Foundation\Vite::class, $viteMock);
}