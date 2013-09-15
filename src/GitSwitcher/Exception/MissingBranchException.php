<?php

/*
 * This file is part of the GitSwitcher Utility.
 *
 */

namespace GitSwitcher\Exception;

/**
 * Exception, is thrown when attempting to switch to a branch that can't be found
 */
class MissingBranchException extends \RuntimeException
{
}
