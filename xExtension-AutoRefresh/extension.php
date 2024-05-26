<?php

final class AutoRefreshExtension extends Minz_Extension {
    const DEFAULT_REFRESH_RATE = 1;

	#[\Override]
    public function init() {
        Minz_View::appendScript($this->getFileUrl('script.js', 'js'),'','','');

        $this->registerHook('js_vars', [$this, 'addVariables']);
    }
	#[\Override]
    public function addVariables($vars) {
        $vars[$this->getName()]['configuration'] = [
            'refresh-rate' => $this->getRefreshRate(),
        ];

        return $vars;
    }

	#[\Override]
    public function handleConfigureAction() {
        $this->registerTranslates();

        if (Minz_Request::isPost()) {
            $configuration = [
                'refresh-rate' => Minz_Request::paramString('refresh-rate', self::DEFAULT_REFRESH_RATE),
            ];
            $this->setUserConfiguration($configuration);
        }
    }

	#[\Override]
    public function getRefreshRate() {
        return $this->getUserConfigurationValue('refresh-rate', static::DEFAULT_REFRESH_RATE);
    }
}
